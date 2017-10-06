<nav class="navbar navbar-expand-md navbar-dark bg-dark" role="navigation">
    <a class="navbar-brand" href="<?= URL ?>">
        <img src="{{LOGO_URL}}" height="30" class="d-inline-block align-top" alt="Logo of PicVid">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="navbar-nav mr-auto">
            <a class="nav-item nav-link" href="<?= URL ?>upload"><i class="fa fa-upload" aria-hidden="true"></i>Upload</a>
            <a class="nav-item nav-link" href="<?= URL ?>images"><i class="fa fa-picture-o" aria-hidden="true"></i>Images</a>
        </div>
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i>{{username}}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="<?= URL ?>profile"><i class="fa fa-id-card" aria-hidden="true"></i>Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= URL ?>auth/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="d-flex justify-content-center mt-5">
    <form class="w-25 picvid-file-upload" enctype="multipart/form-data" data-action="<?= URL ?>upload/upload" method="post">
        <input type="hidden" name="token" value="{{token}}"/>
        <div class="alert"></div>
        <div class="form-group">
            <label class="sr-only" for="image-title">Title</label>
            <input class="form-control" id="image-title" type="text" name="image_title" placeholder="Title"/>
        </div>
        <div class="form-group">
            <label class="sr-only" for="image-description">Description</label>
            <textarea class="form-control" id="image-description" name="image_description" placeholder="Beschreibung" rows="3"></textarea>
        </div>
        <div class="form-group">
            <input class="form-control" id="files" name="image_upload" type="file" multiple/>
        </div>
        <label for="files">
            <span>Choose a file...</span>
        </label>
        <button class="btn btn-success"><i class="fa fa-upload"></i>Upload</button>
    </form>
</div>