<nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-inverse bg-inverse">
    <a class="navbar-brand" href="<?= URL ?>">
        <img src="{{LOGO_URL}}" height="40" class="d-inline-block align-top" alt="">
    </a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <div class="navbar-nav mr-auto ml-3">
            <a class="nav-item nav-link" href="<?= URL ?>upload"><i class="fa fa-upload" aria-hidden="true"></i>Upload</a>
        </div>
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="<?= URL ?>profile"><i class="fa fa-user" aria-hidden="true"></i>Profile</a>
            <a class="nav-item nav-link" href="<?= URL ?>auth/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
        </div>
    </div>
</nav>
<div class="d-flex justify-content-center mt-5">
    <form class="w-25" enctype="multipart/form-data" action="<?= URL ?>upload/upload" method="post">
        <div class="alert"></div>
        <div class="form-group">
            <input class="form-control" type="text" name="image_title" placeholder="Titel"/>
        </div>
        <div class="form-group">
            <textarea rows="3" class="form-control" name="image_description" placeholder="Beschreibung"></textarea>
        </div>
        <input type="file" name="image_upload" id="file"/>
        <label for="file">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
        </label>
        <button class="btn btn-success"><i class="fa fa-upload"></i>Upload</button>
    </form>
</div>