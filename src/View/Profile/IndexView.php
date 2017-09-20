<nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-inverse bg-inverse">
    <a class="navbar-brand" href="<?= URL ?>">
        <img src="{{LOGO_URL}}" height="40" class="d-inline-block align-top" alt="">
    </a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <div class="navbar-nav mr-auto"></div>
        <div class="navbar-nav">
            <a class="nav-item nav-link float-right" href="<?= URL ?>profile"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
            <a class="nav-item nav-link float-right" href="<?= URL ?>auth/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
        </div>
    </div>
</nav>
<div class="d-flex justify-content-center mt-5">
    <div class="card w-25">
        <form action="<?= URL ?>profile/save" method="post">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="input-group">
                        <i class="fa fa-id-card-o input-group-addon" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="profile_username" value="{{user_username}}" placeholder="username"/>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="input-group">
                        <i class="fa fa-lock input-group-addon" aria-hidden="true"></i>
                        <input type="password" class="form-control" name="profile_password" placeholder="new password"/>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="input-group">
                        <i class="fa fa-user input-group-addon" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="profile_firstname" value="{{user_firstname}}" placeholder="firstname"/>
                        <input type="text" class="form-control" name="profile_lastname" value="{{user_lastname}}" placeholder="lastname"/>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="input-group">
                        <i class="fa fa-envelope-o input-group-addon" aria-hidden="true"></i>
                        <input type="email" class="form-control" name="profile_email" value="{{user_email}}" placeholder="email"/>
                    </div>
                </li>
            </ul>
            <input type="hidden" name="profile_id" value="{{user_id}}"/>
            <div class="card-block">
                <button class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i>Save</button>
            </div>
        </form>
    </div>
</div>