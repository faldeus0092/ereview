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
                  <h2>Sign-Up Form</h2>
                  <p>
                    Please fill in your account details. Fields marked with <span style=color:red>*</span> are mandatory
                    <?php if (strlen($error)>0) {?>
                    </br><span style=color:red><?php echo $error; ?></span>
                    <?php  }?>
                  </p>
                  <div align="center">
                  <?php echo form_open_multipart(base_url()."AccountCtl/signingup");?>
                      <table>
                        <tr>
                          <td>*Nama</td>
                          <td><input type="text" id="nama" name="nama" width="100"/></td>
                        </tr>
                        <tr>
                          <td>*Username</td>
                          <td><input type="text" id="username" name="username" width="100"/></td>
                        </tr>
                        <tr>
                          <td>*E-mail</td>
                          <td><input type="text" id="email" name="email" width="100"/></td>
                        </tr>
                        <tr>
                          <td>*Password</td>
                          <td><input type="password" id="katasandi" name="katasandi" width="100"/></td>
                        </tr>
                        <tr>
                          <td>*Roles</td>
                          <td><input type="checkbox" id="editor" name="roles[]" value="1" CHECKED/>Editor<br/>
                          <input type="checkbox" id="reviewer" name="roles[]" value="2"/>Reviewer
                          </td>
                        </tr>
                        <tr id="norek" style="display: none">
                          <td>No. Rekening</td>
                          <td>:</td>
                          <td><input type="text" id="no_rek" name="no_rek" width="100">
                          </td>
                        </tr>
                        <tr id="kompetensi" style="display: none">
                          <td>Kompetensi</td>
                          <td>:</td>
                          <td>
                            <textarea id="kompetensi" name="kompetensi"></textarea>
                          </td>
                        </tr>
                        <tr>
                          <td>Profile Photo</td>
                          <td><input type="file" id="userfile" name="userfile" width="20"/></td>
                        </tr>
                      </table>
                      <input type="submit" value="Signup">
                    </form>
                    </p>
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
<script type="text/javascript">
   document.getElementById("reviewer").addEventListener("click", function(){
    var x = document.getElementById("reviewer").checked;
    if (x == true) {
      document.getElementById("norek").style.display='';
      document.getElementById("kompetensi").style.display='';
    } else {
      document.getElementById("norek").style.display='none';
      document.getElementById("kompetensi").style.display='none';
    }
});
 </script>
