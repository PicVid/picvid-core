<?php
/**
 * Namespace for all DataMapper of PicVid.
 */
namespace PicVid\Domain\DataMapper;

use PicVid\Core\Database;
use PicVid\Domain\Entity\IEntity;
use PicVid\Domain\Entity\Image;

/**
 * Class ImageMapper
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\DataMapper
 */
class ImageMapper extends DataMapper
{
    /**
     * ImageMapper constructor.
     * @param \PDO $pdo An instance of PDO to use the database.
     */
    public function __construct(\PDO $pdo)
    {
        $this->table = 'image';
        $this->pdo = $pdo;
    }

    /**
     * Method to build the DataMapper to organize the Image Entity.
     * @return IDataMapper The DataMapper to organize the Image Entity.
     */
    public static function build(): IDataMapper
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create an Image Entity on database.
     * @param IEntity $image The Image Entity to be stored on the database.
     * @return bool The status of whether the Image Entity could be created.
     */
    public function create(IEntity $image): bool
    {
        //check if an Image Entity is available.
        if (!($image instanceof Image)) {
            return false;
        }

        //check whether an ID already exists.
        if ($image->hasID()) {
            return false;
        }

        //create and set the sql query.
        $sql = 'INSERT INTO '.$this->table.' (description, filename, size, title, type) ';
        $sql .= 'VALUES (:description, :filename, :size, :title, :type);';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute the query.
        $sth->bindParam(':description', $image->description, \PDO::PARAM_STR);
        $sth->bindParam(':filename', $image->filename, \PDO::PARAM_STR);
        $sth->bindParam(':size', $image->size, \PDO::PARAM_INT);
        $sth->bindParam(':title', $image->title, \PDO::PARAM_STR);
        $sth->bindParam(':type', $image->type, \PDO::PARAM_STR);
        $state = $sth->execute();

        //get the last insert ID from PDO and return state.
        if ($state) {
            $this->insert_id = $this->pdo->lastInsertID();
            return true;
        } else {
            $this->insert_id = 0;
            return false;
        }
    }

    /**
     * Method to delete an Image Entity on database.
     * @param IEntity $image The Image Entity to be deleted on the database.
     * @return bool The status of whether the Image Entity could be deleted.
     */
    public function delete(IEntity $image): bool
    {
        //check if an Image Entity is available.
        if (!($image instanceof Image)) {
            return false;
        }

        //check whether an ID exists.
        if (!$image->hasID()) {
            return false;
        }

        //create and set the sql query.
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :id;';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute the query.
        $sth->bindParam(':id', $image->id, \PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * Method to find Image Entities by a SQL condition.
     * @param string $condition The SQL condition to filter the Image Entities.
     * @return array An array with all found Image Entities.
     */
    public function find(string $condition = ''): array
    {
        return $this->findForEntity($condition, new Image());
    }

    /**
     * Method to save an Image Entity on database.
     * @param IEntity $image The Image Entity to be saved on the database.
     * @return bool The status of whether the Image Entity could be saved.
     */
    public function save(IEntity $image): bool
    {
        //check if an Image Entity is available.
        if (!($image instanceof Image)) {
            return false;
        }

        //create or update the Image Entity.
        return ($image->hasID()) ? $this->update($image) : $this->create($image);
    }

    /**
     * Method to update an Image Entity on database.
     * @param IEntity $image The Image Entity to be updated on the database.
     * @return bool The status of whether the Image Entity could be updated.
     */
    public function update(IEntity $image): bool
    {
        //initialize the insert ID.
        $this->insert_id = 0;

        //check if an Image Entity is available.
        if (!($image instanceof Image)) {
            return false;
        }

        //check whether an ID exists.
        if (!$image->hasID()) {
            return false;
        }

        //create and set the sql query.
        $sql = 'UPDATE '.$this->table.' SET description = :description, filename = :filename, ';
        $sql .= 'size = :size, title = :title, type = :type WHERE id = :id';
        $sth = $this->pdo->prepare($sql);

        //bind the values to the query and execute the query.
        $sth->bindParam(':description', $image->description, \PDO::PARAM_STR);
        $sth->bindParam(':filename', $image->filename, \PDO::PARAM_STR);
        $sth->bindParam(':size', $image->size, \PDO::PARAM_INT);
        $sth->bindParam(':title', $image->title, \PDO::PARAM_STR);
        $sth->bindParam(':type', $image->type, \PDO::PARAM_STR);
        $sth->bindParam(':id', $image->id, \PDO::PARAM_INT);
        return $sth->execute();
    }
}