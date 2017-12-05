<nav class="navbar navbar-expand-md navbar-dark bg-dark" role="navigation">
    <a class="navbar-brand" href="{{URL}}">
        <img src="{{LOGO_URL}}" height="30" class="d-inline-block align-top" alt="Logo of PicVid">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="navbar-nav mr-auto">
            <a class="nav-item nav-link" href="{{URL}}upload"><i class="fa fa-upload" aria-hidden="true"></i>Upload</a>
            <a class="nav-item nav-link" href="{{URL}}images"><i class="fa fa-picture-o" aria-hidden="true"></i>Images</a>
        </div>
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i>{{username}}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{URL}}profile"><i class="fa fa-id-card" aria-hidden="true"></i>Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{URL}}auth/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php
//get all the images from database.
$images = \PicVid\Domain\Repository\ImageRepository::build()->findAll();
?>
<div class="container-fluid">
    <div class="row img-grid justify-content-center">
        <?php
            if (count($images) < 1) { echo '<div class="col-12 col-md-6 col-lg-6 col-xl-4 mt-4"><div class="alert alert-warning" role="alert"><i class="fa fa-picture-o" aria-hidden="true"></i> Es sind keine Bilder verfügbar! Über den <a class="alert-link" href="{{URL}}upload">Upload</a> kannst du deine Bilder hochladen.</div></div>'; } else {
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
                            <i class="fa fa-download" aria-hidden="true"></i>Download
                        </a>
                        <a class="btn btn-sm btn-info info" href="{{URL}}images/info/<?= $image->id ?>">
                            <i class="fa fa-info" aria-hidden="true"></i>Info
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
                            <i class="fa fa-download" aria-hidden="true"></i>Download
                        </a>
                        <a class="btn btn-sm btn-info info" href="{{URL}}images/info/<?= $image->id ?>">
                            <i class="fa fa-info" aria-hidden="true"></i>Info
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
                            <i class="fa fa-download" aria-hidden="true"></i>Download
                        </a>
                        <a class="btn btn-sm btn-info info" href="{{URL}}images/info/<?= $image->id ?>">
                            <i class="fa fa-info" aria-hidden="true"></i>Info
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