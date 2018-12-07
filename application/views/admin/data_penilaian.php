<!doctype html>
<html lang="en">

<?php include ('decorations/header.php');?>
<body class="theme-cyan">
    <div id="wrapper">
    <?php include ('decorations/navbar.php');?>
    	<?php include ('decorations/sidebar.php');?>
			<!-- Start Main Content -->
			<div id="main-content">
				<div class="container-fluid">
					<div class="block-header">
						<div class="row">
							<div class="col-lg-6 col-md-8 col-sm-12">
								<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-angle-double-left"></i></a> Karyawan</h2>
								<ul class="breadcrumb">                            
									<li class="breadcrumb-item">Karyawan</li>
									<li class="breadcrumb-item active">Penilaian Karyawan</li>
								</ul>
							</div>      
						</div>
					</div>
					<div class="row clearfix">
						<div class="col-lg-12">
                            <div class="card">
                                <div class="header">
                                    <?php
                                        if(isset($_SESSION['hapus_sukses']) || isset($_SESSION['update_sukses'])) :
                                            $notif = '';
                                            isset($_SESSION['hapus_sukses']) ? $notif .= $_SESSION['hapus_sukses'] : '';
                                            isset($_SESSION['update_sukses']) ? $notif .= $_SESSION['update_sukses'] : '';
                                        ?>
                                        <div class="alert alert-success">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Sukses!</strong> <?php echo $notif; ?>
                                            </div>
                                    <?php endif;?>

                                    <h5><i class="fa fa-users"></i> <?php echo $judul; ?></h5><br>
                                    <a href="<?php echo base_url();?>admin/add_penilaian" class="btn btn-xs btn-default" role="button" title="Tambah Karyawan">
                                    <i class="icon-plus"></i><span> Tambah</span></a>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModalCenter" title="Import Data">
                                    <i class="fa fa-upload"></i> Import</button>
                                    <a href="<?php echo base_url() ?>report_penilaian/print_penilaian" class="btn btn-xs btn-default" role="button" title="Print Data">
                                    <i class="fa fa-print"></i><span> Print</span></a>
                                    <a href="<?=base_url('report_penilaian/print_penilaian')?>" class="btn btn-xs btn-default" role="button" title="Print Manual">
                                    <i class="fa fa-file-text"></i><span> Manual</span></a>

                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered dataTable" cellspacing="0" id="examples">
                                            <thead style="background-color:#e9ecef;">
                                                <tr style="text-align:center;">
                                                    <th>No.</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>NIK</th>        
                                                    <th>Departemen</th> 
                                                    <th>Jabatan</th> 
                                                    <th>Tanggal Masuk</th> 
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; foreach ($karyawan as $kry): ?>
                                                <tr>
                                                    <td style="text-align:center;"><?= $no; ?></td>
                                                    <td><?= $kry->nama_nl ?></td>
                                                    <td><?= $kry->nik_nl ?></td>
                                                    <td><?= $kry->dep_nl ?></td>
                                                    <td><?= $kry->jabatan_nl ?></td>
                                                    <td><?= $kry->tgl_masuk_nl?></td>
                                                    
                                                    <td style="text-align: center;">
                                                        <a href="<?php echo base_url();?>admin/detail_penilaian/<?php echo $kry->id_nl;?>" class="btn btn-xs btn-success m-r-5" role="button" title="Detail">
                                                        <i class="icon-magnifier"></i>&nbsp;
                                                        <a href="<?php echo base_url();?>admin/edit_penilaian/<?php echo $kry->id_nl;?>" class="btn btn-xs btn-primary m-r-5" role="button" title="Edit">
                                                        <i class="icon-pencil"></i>&nbsp;
                                                        <a href="<?=base_url('report_penilaian/print_penilaian/'.$kry->id_nl)?>" class="btn btn-xs btn-dark m-r-5" role="button" title="Cetak">
                                                        <i class="fa fa-file-text"></i></a>
                                                        <a href="<?php echo base_url();?>admin/delete_penilaian/<?php echo $kry->id_nl;?>" onclick="return confirm('Apakah Anda Yakin?');" 
                                                        class="btn btn-xs btn-danger m-r-5" role="button" title="Hapus">
                                                        <i class="icon-trash"></i></a> 
                                                    </td>
                                                </tr>
                                                <?php $no++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
					    </div>
				    </div>
			    </div>
			    <!-- End Main Content -->       
            <?php include ('decorations/footer.php');?>
        </body>
    </html>