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
                  <div class="col-sm-10">
                    <button href ="<?php echo site_url('PaymentCtl/withdrawFunds/' . $id_user); ?>" type="submit" class="btn btn-success">Withdraw</button>
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