<nav class="navbar navbar-expand-md navbar-dark bg-dark" role="navigation">
    <a class="navbar-brand mr-5" href="{{URL}}">
        <img src="{{LOGO_URL}}" height="30" class="d-inline-block align-top" alt="Logo of PicVid">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="navbar-nav mr-auto">
            <a class="nav-item nav-link mr-3" href="{{URL}}upload">
                <i class="fas fa-upload" aria-hidden="true"></i>
                <span>Upload</span>
            </a>
            <a class="nav-item nav-link" href="{{URL}}images">
                <i class="far fa-image" aria-hidden="true"></i>
                <span>Bilder</span>
            </a>
        </div>
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user" aria-hidden="true"></i>{{username}}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{URL}}profile"><i class="fas fa-id-card" aria-hidden="true"></i>Profil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{URL}}auth/logout"><i class="fas fa-sign-out-alt" aria-hidden="true"></i>Abmelden</a>
                </div>
            </div>
        </div>
    </div>
</nav>