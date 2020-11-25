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
                  <h1>EARNINGS</h1>
                  <h3>
                    Current Balance: <a><?php echo $balance[0]['saldo'] ?>$</a><br>
                  </h3>
                  <p>
	                    <?php if (strlen($msg)>0) echo $msg;?>
	                </p>
                  <div class="col-lg-8">
                        <?= form_open_multipart('PaymentCtl/withdrawfunds/'); ?>
                            <div class="form-group row">
                                <label for="withdraw" class="col-sm-2 col-form-label">Withdraw Amount</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="withdraw" name="withdraw" value="<?= $balance[0]['saldo']; ?>"><a>$</a>
                                </div>
                            </div>
                            
                            <div class="form-group row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Withdraw</button>
                                </div>
                            </div>

                            <?= form_close(); ?>
                        </div>
              
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