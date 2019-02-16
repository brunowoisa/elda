<script>
  $('.m-topbar__userpic').html('<img src="<?php echo base_url(); ?>assets/_UPLOADS/USUARIOS/<?php echo $this->session->userdata('usuario')->id; ?>/FOTO/<?php echo $this->session->userdata('usuario')->foto; ?>" class="m--img-rounded m--marginless m--img-centered" alt="Foto">');
  $('.m-card-user__pic').html('<img src="<?php echo base_url(); ?>assets/_UPLOADS/USUARIOS/<?php echo $this->session->userdata('usuario')->id; ?>/FOTO/<?php echo $this->session->userdata('usuario')->foto; ?>" class="m--img-rounded m--marginless m--img-centered" alt="Foto">');
</script>