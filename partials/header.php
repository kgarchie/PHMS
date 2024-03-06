<style>
    .logo {
        font-size: 1.5rem;
        font-weight: 800;
        color: #000;
        font-family: 'Poppins', sans-serif;
    }
</style>
<header class="navbar navbar-expand-lg bg-body-tertiary shadow-sm w-100">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"><span class="logo">SFH</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        <?php
                            if (getAuthCookie()) echo "href='dashboard.php'";
                            else echo "href='login.php'";
                        ?>
                    >Dashboard</a>
                </li>
            </ul>
            <div class="d-flex btn-group" role="search">
                <?php
                    if (getAuthCookie()) {
                        echo '<a href="/login.php" class="btn btn-success" style="margin-right: 1rem">Login</a>';
                        echo '<a href="/register.php" class="btn btn-outline-success">Sign Up</a>';
                    } else {
                        echo '<a href="/logout.php" class="btn btn-secondary">Logout</a>';
                    }
                ?>
            </div>
        </div>
    </div>
</header>