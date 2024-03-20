<div class="d-flex flex-column shadow-sm aside shadow">
    <span class="aside-nav-header mb-3">Navigation</span>
    <ul class="aside-nav">
        <li><a href="/patients.php">Patients</a></li>
        <li><a href="#">Doctors</a></li>
        <li><a href="/appointments.php">Appointments</a></li>
        <li><a href="#">Prescriptions</a></li>
        <li><a href="#">Vaccinations</a></li>
        <li><a href="#">Labs</a></li>
    </ul>
</div>
<style>
    .aside {
        background-color: white;
        display: inline;
        width: 300px;
        max-width: 20vw;
        padding-left: 1rem;
        padding-top: 1rem;
    }

    .aside-nav-header {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .aside-nav {
        list-style: none;
        padding: 0;
        min-height: 500px;
        display: flex;
        gap: 0.5rem;
        flex-direction: column;
    }

    .aside-nav a {
        width: 100%;
        height: 100%;
    }

    .aside-nav li {
        padding: 1rem 0 1rem 25%;
        background-color: #f4f4f4;
        border-radius: 5px 0 0 10px;
        cursor: pointer;
    }

    .aside-nav li:hover {
        background-color: #e4e4e4;
    }

    .aside-nav a.active {
        font-weight: 600;
    }
</style>
<script defer>
    document.querySelectorAll('.aside-nav a').forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        }
    });
</script>