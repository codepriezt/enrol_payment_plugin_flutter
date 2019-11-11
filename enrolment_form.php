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

$username = 200208;
$password = "g1Kzk8GY";
$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$amount = $cost;
$productinfo = $coursefullname;
$label = "Pay Now";
$transactionType ="PAYMENT";
// $returnUrl ="http://qa.payu.co.za/integration-qa/internal-tools/demos/developer/payu-redirect-payment-page/send-getTransaction-via-soap.php";
// $cancelUrl="http://qa.payu.co.za/integration-qa/internal-tools/demos/developer/payu-redirect-payment-page/cancel-page.php"; 
$supportedPaymentMethods ="DEBITCARD";
$hash = '';



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
	<form method="post" action="" >
		<input type="hidden" id="username" name="Username" value="<?php echo $username; ?>" />
		<input type="hidden"  id="password" name="Password" value="<?php echo $password; ?>" />
		<input type="hidden"  id="amount" name="amount" value="<?php echo $amount; ?>" />
		<input type="hidden"  id="description" name="description" value="<?php echo $productinfo; ?>" />
		<input type="hidden"  id="safeKey" name="safeKey" value="<?php echo $safeKey; ?>" />
		<input type="hidden"  id="merchantReference" name="merchantReference" value="<?php echo $txnid; ?>" />
		<input type="hidden"  id="transactionType" name="transactionType" value="<?php echo $transactionType; ?>" />	
		<input type="hidden"  id="returnUrl" name="returnUrl" value="<?php echo $returnUrl; ?>" />		
		<input type="hidden"  id="cancelUrl" name="cancelUrl" value="<?php echo $cancelUrl; ?>" />		
		<input type="hidden"  id="firstname" name="firstname" value="<?php echo $USER->firstname; ?>" />
		<input type="hidden"  id="email" name="email" value="<?php echo $USER->email; ?>" />
		<input type="hidden"  id="phone" name="phone" value="<?php echo $_SESSION['timestamp']; ?>" />
		<input type="hidden"  name="surl" value="<?php echo $CFG->wwwroot; ?>/enrol/payumoney/ipn.php" />
         <input type="hidden" name="udf1" value="<?php echo $udf1 ?>" />
		<input type="hidden"  name="udf2" value="<?php echo $enrolperiod; ?>" />
		
		<input type="submit" id="sub_button" value="" onClick="makeOrder" />
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
<?php
		echo '<script type="text/javascript">
		window.location.href="'.$CFG->wwwroot.'/enrol/payumoney/order.js?";
		</script>'
?>

	


