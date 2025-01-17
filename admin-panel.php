<?php 
    if(!defined("ADMIN_PANEL"))
        header('Location: index.php');
    $current_url = basename($_SERVER['PHP_SELF']);
?>

<nav id="sidebar">
    <button type="button" id="sidebarCollapseInside" class="btn btn-secondary sidebar-button-inisde">
        <i class="fas fa-angle-double-left"></i>
    </button>
    <div class="sidebar-header">
        <h3>Панель администратора</h3>
        <strong>PA</strong>
    </div>

    <ul class="list-unstyled components">
        <li class="<?php if($current_url=="admin_featured_categories.php" || $current_url=="admin_slides.php") echo "active" ?>">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-home" style="margin-right: 5px;"></i>
                Главная страница
            </a>
            <ul class="collapse list-unstyled home-submenu" id="homeSubmenu">
                        <li>
                            <a href="admin_featured_categories.php">Рекомендуемые категории</a>
                        </li>
                        <li>
                            <a href="admin_slides.php">Управление слайдами</a>
                        </li>
                    </ul>
        </li>

        <li class="<?php if($current_url=="admin_categories.php") echo "active" ?>">
            <a href="admin_categories.php">
                <i class="fas fa-tags" style="margin-right: 5px;"></i>
                Категории
            </a>
        </li>
        <li  class="<?php if($current_url=="admin_products.php") echo "active" ?>">
            <a href="admin_products.php">
                <i class="fas fa-boxes" style="margin-right: 5px;"></i>
                Товары
            </a>
        </li>
        <li class="<?php if($current_url=="admin_users.php") echo "active" ?>">
            <a href="admin_users.php">
                <i class="fas fa-users" style="margin-right: 5px;"></i>
                Пользователи
            </a>
        </li>
    </ul>
</nav>