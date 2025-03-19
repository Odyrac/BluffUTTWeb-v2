<!doctype html>
<html lang="fr">

<?php include('./components/head.php'); ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <?php
    $page = 'timer';
    include('./components/sidebar.php'); ?>

    <!--  Main wrapper -->
    <div class="body-wrapper">

      <?php include('./components/header.php'); ?>

      <?php include('./components/functions.php'); ?>

      <div class="container-fluid">

        <!--  Row 1 -->
        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">

                <h5 class="card-title fw-semibold mb-4">Timer</h5>

                <p>Stack de départ : 1,500$ (2x 500$ + 3x 100$ + 2x 50$ + 2x 25$ + 3x 10$ + 4x 5$)</p>

                <div class="mt-5 border rounded p-4 d-flex justify-content-between align-items-center">

                  <h2 id="round" class="mb-0">Round 1</h2>
                  <h1 class="clock mb-0">15:00</h1>

                  <div id="poker_blinds">
                    <div class="blinds text-center">
                      <small>Blinds</small>
                      <h2 class="mb-0">
                        <span class="small-blind">5</span>
                        <span class="separator">/</span>
                        <span class="big-blind">10</span>
                      </h2>
                    </div>
                  </div>
                </div>

                <div class="mt-3 d-flex justify-content-center">
                  <button type="submit" class="btn btn-success" id="poker_play_pause">Play</button>
                  <button type="submit" class="btn btn-primary ms-2" id="poker_next_round">Next Round</button>
                  <button type="submit" class="btn btn-danger ms-2 reset">Reset</button>
                </div>

                <audio id="alarm" controls="controls" style="display:none">
                  <source src="https://www.soundjay.com/clock/sounds/alarm-clock-01.mp3" type="audio/mpeg">
                  Your browser does not support the audio element.
                </audio>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php include('./components/scripts.php'); ?>

  <script>
    var Poker = (function() {
      var round = 1,
        duration = 900,
        timer = duration,
        blinds = [{
          small: 5,
          big: 10
        }, {
          small: 10,
          big: 20
        }, {
          small: 15,
          big: 30
        }, {
          small: 20,
          big: 40
        }, {
          small: 30,
          big: 60
        }, {
          small: 50,
          big: 100
        }, {
          small: 60,
          big: 120
        }, {
          small: 80,
          big: 160
        }, {
          small: 100,
          big: 200
        }, {
          small: 150,
          big: 300
        }, {
          small: 200,
          big: 400
        }, {
          small: 300,
          big: 600
        }, {
          small: 400,
          big: 800
        }, {
          small: 500,
          big: 1000
        }, {
          small: 600,
          big: 1200
        }, {
          small: 800,
          big: 1600
        }, {
          small: 1000,
          big: 2000
        }],
        interval_id;

      return {
        isGamePaused: function() {
          return !interval_id ? true : false;
        },
        playAlarm: function() {
          $('#alarm')[0].play();
        },
        reset: function() {
          // reset timer
          this.resetTimer();

          this.stopClock();

          this.updateClock(timer);

          // reset play/pause button
          this.updatePlayPauseButton();

          // reset round
          round = 1;

          this.updateRound(round);

          // increase blinds
          this.updateBlinds(round);
        },
        resetTimer: function() {
          timer = duration;
        },
        startClock: function() {
          var that = this;

          interval_id = setInterval(function() {
            that.updateClock(timer);

            timer -= 1;
          }, 1000);
        },
        startNextRound: function() {
          // reset timer
          this.resetTimer();

          this.stopClock();

          this.updateClock(timer);

          // reset play/pause button
          this.updatePlayPauseButton();

          // increase round
          round += 1;

          this.updateRound(round);

          // increase blinds
          this.updateBlinds(round);
        },
        stopClock: function() {
          clearInterval(interval_id);
          interval_id = undefined;
        },
        updateBlinds: function(round) {
          var round_blinds = blinds[round - 1] || blinds[blinds.length];

          $('.small-blind').html(round_blinds.small);
          $('.big-blind').html(round_blinds.big);
        },
        updateClock: function(timer) {
          var minute = Math.floor(timer / 60),
            second = (timer % 60) + "",
            second = second.length > 1 ? second : "0" + second;

          $('.clock').html(minute + ":" + second);

          if (timer <= 0) {
            this.startNextRound();

            this.playAlarm();

            this.startClock();

            // update play/pause button
            this.updatePlayPauseButton();
          }
        },
        updatePlayPauseButton: function() {
          var pause_play_button = $('#poker_play_pause');

          if (this.isGamePaused()) {
            pause_play_button.removeClass('btn-warning');
            pause_play_button.addClass('btn-success');
            pause_play_button.html('Play');
          } else {
            pause_play_button.removeClass('btn-success');
            pause_play_button.addClass('btn-warning');
            pause_play_button.html('Pause');
          }
        },
        updateRound: function(round) {
          $('#round').html('Round' + ' ' + round);
        }
      };
    }());

    $('#poker_play_pause').on('click', function(event) {
      if (Poker.isGamePaused()) {
        Poker.startClock();
      } else {
        Poker.stopClock();
      }

      // update play/pause button
      Poker.updatePlayPauseButton();
    });

    $('#poker_next_round').on('click', function(event) {
      Poker.startNextRound();
    });

    $('body').on('keypress', function(event) {
      if (Poker.isGamePaused()) {
        Poker.startClock();
      } else {
        Poker.stopClock();
      }

      // update play/pause button
      Poker.updatePlayPauseButton();
    });


    $('.reset').on('click', function(event) {
      if (!confirm('Voulez-vous vraiment réinitialiser le timer ?')) {
        return false;
      }
      Poker.reset();
    });
  </script>

</body>

</html>