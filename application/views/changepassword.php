<section id="maincontent">
  <div class="container">
    <div class="row">
      <div class="span12">
        <div class="tagline centered">
          <div class="row">
            <div class="span12">
              <div class="tagline_text">
                <br />
                <h2>Change Password Page</h2>
                <?= $this->session->flashdata('message');?>
                <?php echo form_open_multipart(base_url()."AccountCtl/changingPassword");?>
                            <table>
                                <tr>
                                    <td>Username:</td>
                                    <td><input type="text" id="username" name="username" width="100" value="<?= $user['username']; ?>" readonly ></td>
                                </tr>
                                <tr>
                                    <td>Current Password:</td>
                                    <td><input type="text" id="currentpassword" name="currentpassword" width="100"/></td>
                                    <?= form_error('currentpassword', '<small class="text-danger pl-3">', '</small>');?>
                                </tr>
                                <tr>
                                    <td>New Password:</td>
                                    <td><input type="text" id="newpassword" name="newpassword" width="100"/></td>
                                    <?= form_error('newpassword', '<small class="text-danger pl-3">', '</small>');?>
                                </tr>
                            </table>
                            <div class="form-group row">
                                <div class="col-sm">
                                    <button type="submit" class="btn btn-primary">Change</button>
                                </div>
                            </div>

                        </form>
                            <?= form_close(); ?>
                        </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end tagline -->
      </div>
    </div>
  </div>
</section>