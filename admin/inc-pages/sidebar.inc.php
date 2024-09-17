        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">เมนู</li>
                        <li>
                            <a href="/admin/home?type=all" class="waves-effect"><i class="feather-edit-3"></i><span>รายการแจ้งซ่อม</span></a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="feather-edit-3"></i><span>รายงาน</span></a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="/admin/report">รายงานซ่อม</a></li>
                                <li><a href="/admin/assets-report">รายงานรัพย์สินรายชิ้น</a></li>
                            </ul>
                        </li>
                        <li class="menu-title">การตั้งค่า</li>
                        <?php if($_SESSION['adminGroup'] == 1) { ?>
                        <li>
                            <a href="/admin/user?type=all" class="waves-effect"><i class="feather-edit-3"></i><span>จัดการสมาชิก</span></a>
                        </li>
                        <li>
                            <a href="/admin/dept" class="waves-effect"><i class="feather-edit-3"></i><span>จัดการแผนก</span></a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="/admin/type" class="waves-effect"><i class="feather-edit-3"></i><span>จัดการประเภท</span></a>
                        </li>
                        <li>
                            <a href="/admin/vendor" class="waves-effect"><i class="feather-edit-3"></i><span>จัดการผู้ปฏิบัติงาน</span></a>
                        </li>
                    </ul>

                    
                </div>
                <!-- Sidebar -->
            </div>
        </div>