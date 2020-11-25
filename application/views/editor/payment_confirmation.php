<section id="maincontent">
  <div class="container">
    <div class="row">
      <div class="span12">
        <div class="tagline centered">
          <div class="row">
            <div class="span12">
              <div class="tagline_text">
                <br />
                <h2>Please Confirm Your Order</h2>
                <div align="center">
                  <?php
                  foreach ($info as $item) {
                  ?>
                    <?= form_open_multipart(base_url().'PaymentCtl/payPayment/'.$item['id_assignment'].'/'.$item['id_reviewer'].'/'.$item['id_task'].'/'.$item['page']*10.);?>
                    <table>
                      <tr>
                        <td>Title </td>
                        <td><input type="text" id="judul" name="judul" width="100" value="<?php echo $item['judul'] ?>" readonly /></td>
                      </tr>
                      <tr>
                        <td>Reviewed by</td>
                        <td><input type="text" id="username" name="username" width="100" value="<?php echo $item['nama'] ?>" readonly></td>
                      </tr>
					            <tr>
                        <td>Page Count</td>
                        <td><input type="text" id="username" name="username" width="100" value="<?php echo $item['page'] ?>" readonly></td>
                      </tr>
					            <tr>
                        <td>Total Price</td>
                        <td><input type="text" id="username" name="username" width="100" value="<?php echo ($item['page']*10)."$";?>" readonly></td>
                      </tr>
                      <tr>
                        <td>Reviewer's Bank Account</td>
                        <td><input type="text" id="username" name="username" width="100" value="<?= $item['no_rek'] ?>" readonly></td>
                      </tr>
                      <tr>
                        <td>Upload Proof of Payment</td>
                        <td class="col-lg-9">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="userfile" name="userfile"></input>
                          </div>
                        </td>
                      </tr>

                    </table>
                    <div class="form-group row">
                      <div class="col-sm">
                        <button type="submit" class="btn btn-primary">Upload</button>
                      </div>
                    </div>
                    </form>

                    <?= form_close(); ?>
                  <?php }  ?>
				  <a href=<?php echo base_url().'editorctl/viewtask';?> class="btn btn-danger">Cancel</a>
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