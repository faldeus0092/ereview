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
                  <h2>Complete your Assignment, <?php echo $namareviewer ?></h2>
                  <p>
                    Please Upload Reviewed Task
                  </p>
                  <div align="center">
                  <?php echo form_open_multipart(base_url()."ReviewerCtl/completingReviewTask/".$id_task);?>
                      <table>
                          <td>Upload Reviewed Task</td>
                          <td><input type="file" id="userfile" name="userfile" width="20"/></td>
                        </tr>
                      </table>
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