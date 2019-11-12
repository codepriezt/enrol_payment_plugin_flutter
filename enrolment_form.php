<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * PayUMoney.com enrolment plugin - enrolment form.
 *
 * @package    enrol_payumoney
 * @copyright  2017 Exam Tutor, Venkatesan R Iyengar
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$amount = $cost;






//$invoice = date('Ymd') . "-" . $instance->courseid . "-" . hash('crc32', $txnid); //udf3
$_SESSION['timestamp'] = $timestamp = time();
$udf1 = $instance->courseid.'-'.$USER->id.'-'.$instance->id.'-'.$context->id;
$enrolperiod = $instance->enrolperiod;//udf2
//Hash Sequence
$hashSequence = $username . "|" . $txnid . "|" . $amount . "|" . $productinfo . "|" . $USER->firstname . "|" . $USER->email . "|" . $udf1 . "|" . $enrolperiod . "|||||||||" . $password;
$fingerprint = strtolower(hash('sha512', $hashSequence));


?>
<div align="center">
<p>This course requires a payment for entry.</p>
<p><b><?php echo $instancename; ?></b></p>
<p><b><?php echo get_string("cost").": {$instance->currency} {$localisedcost}"; ?></b></p>
<p>&nbsp;</p>
<p><img alt="PayUMoney" src="<?php echo $CFG->wwwroot; ?>/enrol/payumoney/pix/payumoneynigeria.jpeg" /></p>
<p>&nbsp;</p>
<p>
	<form>
		<input type="hidden"  id="amount" name="amount" value="<?php echo $amount; ?>" />
		<input type="hidden"  id="merchantReference" name="merchantReference" value="<?php echo $txnid; ?>" />
		<input type="hidden"  id="email" name="email" value="<?php echo $USER->email; ?>" />
		<input type="hidden"  id="phone" name="phone" value="<?php echo $_SESSION['timestamp']; ?>" />
		<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
		<button type="button" id="sub_button" value="" onClick="payWithRave()" />
	</form>
</p>
</div>
<style type="text/css">
#sub_button{
  background: url("<?php echo $CFG->wwwroot; ?>/enrol/payumoney/pix/paynow.png") no-repeat scroll 0 0 transparent;
  color: #000000;
  cursor: pointer;
  font-weight: bold;
  height: 20px;
  padding-bottom:2px;
  width: 301px;
  height: 59px;
}
</style>

<script>
		
const btn = document.querySelector('#sub_button').addEventListener('submit' , payWithRave())
const email = document.querySelector('#email').value
const amount = document.querySelector('#cost').value
const txind = document.querySelector('#txnid').value
const phone = document.querySelector('#phone').value

function payWitRave(){
	const Api_publicKey = FLWPUBK_TEST-3ad6296c3414918d2327d0db4a653a03-X ,
  var x = getpaidSetup({
            PBFPubKey: Api_publicKey ,
            customer_email: email,
			amount: amount,
			customer_phone: phone,
            currency: "NGN",
            txref: txind,
            meta: [{
                orderId:
            }],
            onclose: function() {},
            callback: function(response) {
				var txref = response.tx.txRef; 
				var data = response;
								
                console.log("This is the response returned after a charge", response);
                if (response.tx.chargeResponseCode == "00" || response.tx.chargeResponseCode == "0") {
					console.log(data);
                    window.location.href="'.$CFG->wwwroot.'/enrol/payumoney/ipn.php' + "; 
                } else {
                    console.log(data);
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    }
		

</script>


	


