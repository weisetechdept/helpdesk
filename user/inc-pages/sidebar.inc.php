        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">เมนู</li>
                        <li>
                            <a href="/user/add-ticket" class="waves-effect"><i class="feather-edit-3"></i><span>แจ้งซ่อม</span></a>
                        </li>
                        <li>
                            <a href="/user/list" class="waves-effect"><i class="feather-edit-3"></i><span>รายการซ่อมของฉัน</span></a>
                        </li>
                        <?php if($_SESSION['hd_permission'] == 'manager') { ?>
                            <li>
                                <a href="/user/mgrList" class="waves-effect"><i class="feather-edit-3"></i><span>รออนุมัติ (ผจก.)</span></a>
                            </li>
                        <?php } ?>
                    </ul>

                    
                </div>
                <!-- Sidebar -->
            </div>
        </div>