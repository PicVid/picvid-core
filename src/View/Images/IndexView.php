<?php
//get all the images from database.
$images = \PicVid\Domain\Repository\ImageRepository::build()->findAll();
?>
<div class="container-fluid">
    <div class="row img-grid justify-content-center">
        <?php
            if (count($images) < 1) { echo '<div class="col-12 col-md-6 col-lg-6 col-xl-4 mt-4"><div class="alert alert-warning" role="alert"><i class="far fa-image" aria-hidden="true"></i> Es sind keine Bilder verfügbar! Über den <a class="alert-link" href="{{URL}}upload">Upload</a> kannst du deine Bilder hochladen.</div></div>'; } else {
        ?>

        <div class="col-12 col-md-6 col-lg-6 col-xl-4">

            <?php
            //run through all images of the database to output.
            for ($i = 0; $i < count($images); $i+=3) {
                $image = $images[$i];

                //check whether a Image Entity is available.
                if ($image instanceof \PicVid\Domain\Entity\Image) {
                    ?>
                    <div class="img-grid-item my-3">
                        <img src="<?= $image->getImageURL() ?>" class="img-transparent"/>
                        <a class="btn btn-sm btn-success download" href="{{URL}}images/download/<?= $image->id ?>">
                            <i class="fas fa-download" aria-hidden="true"></i>Download
                        </a>
                        <a class="btn btn-sm btn-info info" href="{{URL}}images/info/<?= $image->id ?>">
                            <i class="fas fa-info" aria-hidden="true"></i>Info
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <?php
            //run through all images of the database to output.
            for ($i = 1; $i < count($images); $i+=3) {
                $image = $images[$i];

                //check whether a Image Entity is available.
                if ($image instanceof \PicVid\Domain\Entity\Image) {
                    ?>
                    <div class="img-grid-item my-3">
                        <img src="<?= $image->getImageURL() ?>" class="img-transparent"/>
                        <a class="btn btn-sm btn-success download" href="{{URL}}images/download/<?= $image->id ?>">
                            <i class="fas fa-download" aria-hidden="true"></i>Download
                        </a>
                        <a class="btn btn-sm btn-info info" href="{{URL}}images/info/<?= $image->id ?>">
                            <i class="fas fa-info" aria-hidden="true"></i>Info
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <?php
            //run through all images of the database to output.
            for ($i = 2; $i < count($images); $i+=3) {
                $image = $images[$i];

                //check whether a Image Entity is available.
                if ($image instanceof \PicVid\Domain\Entity\Image) {
                    ?>
                    <div class="img-grid-item my-3">
                        <img src="<?= $image->getImageURL() ?>" class="img-transparent"/>
                        <a class="btn btn-sm btn-success download" href="{{URL}}images/download/<?= $image->id ?>">
                            <i class="fas fa-download" aria-hidden="true"></i>Download
                        </a>
                        <a class="btn btn-sm btn-info info" href="{{URL}}images/info/<?= $image->id ?>">
                            <i class="fas fa-info" aria-hidden="true"></i>Info
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php } ?>
    </div>
</div>