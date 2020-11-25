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
                  <h2>Add New Reviewing Task</h2>
                  <p>
                  <span style=color:green>Please fill in data about the article you would like to be reviewed.</span> 
                    <?php if (strlen($error)>0) {?>
                    </br><span style=color:red><?php echo $error; ?></span>
                    <?php  }?>
                  </p>
                  <div align="center">
                  <?php echo form_open_multipart(base_url()."editorCtl/addingtask");?>
                      <table>
                        <tr>
                          <td>*Title</td>
                          <td><input type="text" id="judul" name="judul" width="100"/></td>
                        </tr>
                        <tr>
                          <td>*Keywords</td>
                          <td><input type="text" id="katakunci" name="katakunci" width="100"/></td>
                        </tr>
                        <tr>
                          <td>*Authors</td>
                          <td><input type="text" id="authors" name="authors" width="100"/></td>
                        </tr>
                        <tr>
                          <td>Article</td>
                          <td><input type="file" id="userfile" name="userfile" width="20"/></td>
                        </tr>
                        <tr>
                          <td>*Number of Page(s)</td>
                          <td><input type="number" id="page" name="page" width="20"/></td>
                        </tr>
                      </table>
                      <input type="submit" value="Submit">
                    </form>
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