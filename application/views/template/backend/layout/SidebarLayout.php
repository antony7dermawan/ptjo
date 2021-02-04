<div class="pcoded-navigation-label">Navigation</div>
<ul class="pcoded-item pcoded-left-item">


    <!-- Diluar Grouping disini -->
    <li <?php if($this->uri->segment(2)=="buku_besar"){echo 'class="pcoded-hasmenu"';}?>>
        <a href="<?= base_url("c_dashboard/"); ?>" class="waves-effect waves-dark">
        <span class="pcoded-micon">
        <i class="feather icon-credit-card"></i>
        </span>
        <span class="pcoded-mtext">Dashboard</span>
        </a>
    </li>


<?php
$level_user_id = $this->session->userdata('level_user_id');
if($level_user_id==1)
{
    ?>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext" href="<?= base_url("c_t_login_user"); ?>">Setting Dashboard</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_setting_db_bank_coa"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Setting Coa Bank</span>
                </a>
            </li>
            
        </ul>
        <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_setting_db_supplier_coa"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Setting Coa Supplier</span>
                </a>
            </li>
            
        </ul>
    </li>

    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext" href="<?= base_url("c_t_login_user"); ?>">Master Kebun</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_t_m_d_company"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Company</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_t_m_d_level_user"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Level User</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_t_m_a_divisi"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Divisi</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_t_m_a_kendaraan"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Kendaraan</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_t_m_a_no_polisi"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">No Polisi</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_t_m_a_supir"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Supir</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_t_m_a_pks"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">PKS</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_t_m_a_uang_jalan"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Uang Jalan</span>
                </a>
            </li>

        </ul>
    </li>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="feather icon-list"></i></span>
            <span class="pcoded-mtext">Master Accounting</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_ak_m_db_k"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Master Debit/Kredit</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_ak_m_family"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Master Family</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_ak_m_type"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Master Type</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_ak_m_coa"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Master COA</span>
                </a>
            </li>
            <li class="">
                <a href="<?= base_url("c_t_ak_faktur_penjualan_print_setting"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Setting Print Faktur Penjualan</span>
                </a>
            </li>

            <li class="">
                <a href="<?= base_url("c_t_ak_terima_pelanggan_print_setting"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Setting Print Terima Pelanggan</span>
                </a>
            </li>
        </ul>
    </li>

    <?php
}
?>



<?php
if($level_user_id==1 or $level_user_id==2 or $level_user_id==3)
{
    ?>
    <!-- Menu ke dua -->
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="feather icon-list"></i></span>
            <span class="pcoded-mtext">Transaksi Kebun</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_t_t_a_penjualan_pks"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Penjualan PKS</span>
                </a>
            </li>
        </ul>
    </li>
    <?php
}

?>



<?php
if($level_user_id==1 or $level_user_id==2 or $level_user_id==4 or $level_user_id==5)
{
    ?>
    <!-- Menu ke dua -->
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="feather icon-list"></i></span>
            <span class="pcoded-mtext">Transaksi Keuangan</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_t_ak_jurnal_create"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Input Jurnal</span>
                </a>
            </li>
        </ul>
        <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_t_ak_jurnal"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Transaksi Jurnal</span>
                </a>
            </li>
        </ul>

        <?php
        if($level_user_id==1 or $level_user_id==2 or $level_user_id==5)
        {
            ?>
            <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_t_ak_jurnal_history"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">History Jurnal</span>
                </a>
            </li>
            </ul>
            <ul class="pcoded-submenu">
                <li class="">
                    <a href="<?= base_url("c_t_ak_faktur_penjualan"); ?>" class="submenu waves-effect waves-dark">
                        <span class="pcoded-mtext">Faktur Penjualan</span>
                    </a>
                </li>
            </ul>


            
            <?php
        }

        ?>

        
    </li>
    <?php
}
?>

    

    
<?php
if($level_user_id==1)
{
    ?>
    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
            <span class="pcoded-mtext">Admin</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_t_login_user"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">User</span>
                </a>
            </li>
            
        </ul>
    </li>


    <li class="pcoded-hasmenu">
        <a href="javascript:void(0)" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
            <span class="pcoded-mtext">Laporan</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="">
                <a href="<?= base_url("c_laporan"); ?>" class="submenu waves-effect waves-dark">
                    <span class="pcoded-mtext">Detail</span>
                </a>
            </li>
            
        </ul>
    </li>
    <?php
}

?>


    
    

    


    

    


</ul>