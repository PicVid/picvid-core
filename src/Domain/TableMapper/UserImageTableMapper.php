<?php
/**
 * Namespace for all TableMapper of PicVid.
 */
namespace PicVid\Domain\TableMapper;

use PicVid\Core\Database;
use PicVid\Domain\Entity\Image;
use PicVid\Domain\Entity\User;

/**
 * Class UserImageTableMapper
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\TableMapper
 */
class UserImageTableMapper extends TableMapper
{
    /**
     * Method to build the TableMapper to organize the association between User and Image Entities.
     * @return UserImageTableMapper The TableMapper to organize the association between User and Image Entities.
     */
    public static function build() : UserImageTableMapper
    {
        return new self(Database::getInstance()->getConnection());
    }

    /**
     * Method to create a new association between User Entity and Image Entity.
     * @param User $user The User Entity which will be associated with the Image Entity.
     * @param Image $image The Image Entity which will be associated with the User Entity.
     * @return bool The state whether the User could be associated with the Image.
     */
    public function create(User $user, Image $image) : bool
    {
        //check whether a ID is available on the User Entity and Image Entity.
        if (!$user->hasID() || !$image->hasID()) {
            return false;
        }

        //create the association in database and return the state.
        $sql = 'INSERT INTO `user_image` (`user_id`, `image_id`) VALUES (:user_id, :image_id);';
        $sth = $this->pdo->prepare($sql);

        //bind and execute the query and return the state.
        $sth->bindParam(':user_id', $user->id, \PDO::PARAM_INT);
        $sth->bindParam(':image_id', $image->id, \PDO::PARAM_INT);
        return $sth->execute();
    }
}