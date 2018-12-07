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
									<li class="breadcrumb-item active">Training Karyawan</li>
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
                                    <?php endif; ?>

                                    <h5><i class="fa fa-users"></i> <?php echo $judul; ?></h5><br>
                                    <a href="<?php echo base_url();?>admin/add_training" class="btn btn-xs btn-default" role="button" title="Tambah Karyawan">
                                    <i class="icon-plus"></i><span> Tambah</span></a>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModalCenter" title="Import Data">
                                    <i class="fa fa-upload"></i> Import</button>
                                    <a href="<?=base_url('report_training/print_training')?>" class="btn btn-xs btn-default" role="button" title="Print Manual">
                                    <i class="fa fa-file-text"></i><span> Manual</span></a>

                                </div>
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered dataTable" cellspacing="0" id="examples">
                                            <thead style="background-color:#e9ecef;">
                                                <tr style="text-align:center;">
                                                    <th>No.</th>
                                                    <th>Nama Pemohon</th>                                    
                                                    <th>NIK</th>                                    
                                                    <th>Jabatan</th> 
                                                    <th>Tanggal Permohonan</th> 
                                                    <th>Judul Training</th>
                                                    <th>Penyelenggara</th>
                                                    <th style="text-align:center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; foreach ($karyawan as $kry): ?>
                                                <tr>
                                                    <td style="text-align:center;"><?= $no; ?></td>
                                                    <td><?= $kry->nama_pemohon_tr ?></td>
                                                    <td><?= $kry->nik_pemohon_tr ?></td>
                                                    <td><?= $kry->jabatan_pemohon_tr ?></td>
                                                    <td><?= $kry->tgl_permohonan_tr ?></td>
                                                    <td><?= $kry->judul_training_tr ?></td>
                                                    <td><?= $kry->penyelenggara_tr ?></td>
                                                    <td style="text-align: center;">
                                                        <a href="<?php echo base_url();?>admin/detail_training/<?php echo $kry->id_tr;?>" class="btn btn-xs btn-success m-r-5" role="button" title="Detail">
                                                        <i class="icon-magnifier"></i>&nbsp;
                                                        <a href="<?php echo base_url();?>admin/edit_training/<?php echo $kry->id_tr;?>" class="btn btn-xs btn-primary m-r-5" role="button" title="Edit">
                                                        <i class="icon-pencil"></i>&nbsp;
                                                        <a href="<?=base_url('report_training/print_training/'.$kry->id_tr)?>" class="btn btn-xs btn-dark m-r-5" role="button" title="Cetak">
                                                        <i class="fa fa-file-text"></i></a>
                                                        <a href="<?php echo base_url();?>admin/delete_training/<?php echo $kry->id_tr;?>" onclick="return confirm('Apakah Anda Yakin?');" 
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
        </div>
    <?php include ('decorations/footer.php');?> 
    </body>
</html>