<nav class="navbar navbar-expand-md navbar-dark bg-dark" role="navigation">
    <a class="navbar-brand" href="{{URL}}">
        <img src="{{LOGO_URL}}" height="30" class="d-inline-block align-top" alt="Logo of PicVid">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="navbar-nav mr-auto">
            <a class="nav-item nav-link" href="{{URL}}upload"><i class="fas fa-upload" aria-hidden="true"></i>Upload</a>
            <a class="nav-item nav-link" href="{{URL}}images"><i class="far fa-image" aria-hidden="true"></i>Bilder</a>
        </div>
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user" aria-hidden="true"></i>{{username}}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{URL}}profile"><i class="fas fa-id-card" aria-hidden="true"></i>Profil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{URL}}auth/logout"><i class="fas fa-sign-out-alt" aria-hidden="true"></i>Abmelden</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row justify-content-center pt-3 pt-sm-5">
        <div class="col col-12 col-md-8 col-lg-6 col-xl-5">
            <form class="ajax" data-action="{{URL}}profile/save" method="post">
                <div class="alert mb-2" role="alert"></div>
                <input type="hidden" name="token" value="{{token}}"/>
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fas fa-id-card input-group-text d-none d-md-inline" aria-hidden="true"></i>
                                    <label class="sr-only" for="password">Benutzername</label>
                                </div>
                                <input type="text" class="form-control" id="username" name="profile_username" value="{{user_username}}" placeholder="Benutzername"/>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fas fa-lock input-group-text d-none d-md-inline" aria-hidden="true"></i>
                                    <label class="sr-only" for="password">Neues Passwort</label>
                                </div>
                                <input type="password" class="form-control" id="password" name="profile_password" placeholder="Neues Passwort"/>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fas fa-user input-group-text d-none d-md-inline" aria-hidden="true"></i>
                                    <label class="sr-only" for="firstname">Vorname</label>
                                </div>
                                <input type="text" class="form-control" id="firstname" name="profile_firstname" value="{{user_firstname}}" placeholder="Vorname"/>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fas fa-user input-group-text d-none d-md-inline" aria-hidden="true"></i>
                                    <label class="sr-only" for="lastname">Nachname</label>
                                </div>
                                <input type="text" class="form-control col-12" id="lastname" name="profile_lastname" value="{{user_lastname}}" placeholder="Nachname"/>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fas fa-envelope input-group-text d-none d-md-inline" aria-hidden="true"></i>
                                    <label class="sr-only" for="email">E-Mail</label>
                                </div>
                                <input type="email" class="form-control" id="email" name="profile_email" value="{{user_email}}" placeholder="E-Mail"/>
                            </div>
                        </li>
                        <li class="list-group-item d-none d-sm-flex align-items-center">
                            <i class="far fa-chart-bar d-none d-md-inline pl-3" aria-hidden="true"></i>
                            <span class="pl-2">Bilder: {{count-images}}</span></label>
                            <i class="fas fa-exclamation-triangle d-none d-md-inline pl-3 ml-2 mr-0" aria-hidden="true"></i>
                            <span class="pl-2 mr-4">Dateien: {{count-unused-files}}</span>
                            <a class="btn btn-sm btn-danger mr-2" href="{{URL}}profile/clean-images/delete"><i class="fas fa-trash" aria-hidden="true"></i>Löschen</a>
                            <a class="btn btn-sm btn-success" href="{{URL}}profile/clean-images/backup"><i class="far fa-hdd" aria-hidden="true"></i>Backup</a>
                        </li>
                    </ul>
                    <input type="hidden" name="profile_id" value="{{user_id}}"/>
                    <div class="card-body">
                        <button class="btn btn-success btn-sm-block"><i class="fas fa-check" aria-hidden="true"></i>Speichern</button>
                        <a class="btn btn-danger float-right btn-sm-block" href="{{URL}}profile/remove-images"><i class="fas fa-trash" aria-hidden="true"></i>Alle Bilder löschen</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>