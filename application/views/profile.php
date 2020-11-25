<section id="intro">
  </section>
  <section id="maincontent">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div class="tagline centered">
            <div class="row">
              <div class="span12">
                <div class="tagline_text">
                  <h2>Profile Page</h2>
                  <p>
	                    <?php if (strlen($msg)>0) echo $msg;?>
	                </p>
                  <div class="col-md-4">
                    <img src="<?php echo base_url() .'photos/'. $user['photo']?>" class="card-img" width=150 height=200>
                  </div>
                  <div align="center" class="col-md-8">
                  <div class="card-body">
                      <tr>
                        <td width="66%">
                      <table>
                        <tr>
                          <td><strong>Name</strong></td>
                          <td>: <?php echo $user['nama']?></td>
                        </tr>
                        <tr>
                          <td><strong>Username</strong></td>
                          <td>: <?php echo $user['username']?></td>
                        </tr>
                        <tr>
                          <td><strong>E-mail</strong></td>
                          <td>: <?php echo $user['email']?></td>
                        </tr>
                        <tr>
                          <td><strong>Password</strong></td>
                          <td>: <input type="password" id="katasandi" name="katasandi" width="100" value="<?php echo $user['password']?>" readonly/></td>
                        </tr>
                        <tr>
                          <td><strong>Role(s)</strong></td>
                          <td>
                            <?php foreach ($roles as $role){
                              echo $role['nama_grup'] . "  " ;
                            }?>
                          </td>
                        </tr>
                      </td>
                    </tr>
                  </table>
                  </div>
                  </div>
                </div>
                <div class="text-center">
								          <a  class="small" href="<?= base_url('index.php'); ?>/AccountCtl/changePassword">Change Password</a>
                          <br><a  class="small" href="<?= base_url('index.php'); ?>/AccountCtl/changeProfile">Change Profile</a>
							        </div>
              </div>
            </div>
          </div>
          <!-- end tagline -->
        </div>
      </div>
    </div>
  </section>