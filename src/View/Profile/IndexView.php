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
<div class="container-fluid">
    <div class="row justify-content-center pt-2 pt-sm-5">
        <div class="col col-12 col-md-8 col-lg-6 col-xl-4">
            <form class="ajax" data-action="{{URL}}profile/save" method="post">
                <div class="alert mb-2" role="alert"></div>
                <input type="hidden" name="token" value="{{token}}"/>
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="input-group">
                                <i class="fa fa-id-card-o input-group-addon d-none d-md-inline" aria-hidden="true"></i>
                                <input type="text" class="form-control" name="profile_username" value="{{user_username}}" placeholder="username"/>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <i class="fa fa-lock input-group-addon d-none d-md-inline" aria-hidden="true"></i>
                                <input type="password" class="form-control" name="profile_password" placeholder="new password"/>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <i class="fa fa-user input-group-addon d-none d-md-inline" aria-hidden="true"></i>
                                <input type="text" class="form-control" name="profile_firstname" value="{{user_firstname}}" placeholder="firstname"/>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <i class="fa fa-user input-group-addon d-none d-md-inline" aria-hidden="true"></i>
                                <input type="text" class="form-control col-12" name="profile_lastname" value="{{user_lastname}}" placeholder="lastname"/>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <i class="fa fa-envelope-o input-group-addon d-none d-md-inline" aria-hidden="true"></i>
                                <input type="email" class="form-control" name="profile_email" value="{{user_email}}" placeholder="email"/>
                            </div>
                        </li>
                    </ul>
                    <input type="hidden" name="profile_id" value="{{user_id}}"/>
                    <div class="card-body">
                        <button class="btn btn-success btn-sm-block"><i class="fa fa-check" aria-hidden="true"></i>Save</button>
                        <a class="btn btn-danger float-right btn-sm-block" href="{{URL}}profile/remove-images"><i class="fa fa-trash" aria-hidden="true"></i>Remove all Images</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>