<style>
.ft{background:#131a2e;color:#fff;margin-top:60px;padding:46px 0 0}
.ft-g{display:grid;grid-template-columns:repeat(4,1fr);gap:30px}
.ft h4{font-size:18px;font-weight:600;margin-bottom:18px}
.ft li{list-style:none;margin-bottom:12px;font-size:14px}.ft li a:hover{color:#ffec00}
.ci-row{display:flex;gap:12px;align-items:flex-start;margin-bottom:14px;font-size:14px;color:#d8dbe3}
.ci-ic{background:transparent;border-radius:8px;width:36px;height:36px;flex:none;display:flex;align-items:center;justify-content:center}.ci-ic img{width:26px;height:27px;display:block;object-fit:contain}
.copy{border-top:1px solid #2a3350;margin-top:30px;text-align:center;padding:26px 0;font-size:14px}.copy b{color:#e5252a;font-weight:500}
.toast{position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#222;color:#fff;padding:12px 22px;border-radius:8px;display:none;z-index:99}
@media(max-width:800px){.ft-g{grid-template-columns:1fr 1fr;gap:26px}}
@media(max-width:480px){.ft{margin-top:38px;padding-top:32px}.ft-g{grid-template-columns:1fr;gap:24px}.ft h4{font-size:17px;margin-bottom:12px}.ft li{font-size:14px;margin-bottom:10px}.ci-row{font-size:13px}.copy{margin-top:24px;padding:20px 0;font-size:12px;line-height:1.6}}
</style>
<footer class="ft"><div class="wrap"><div class="ft-g">
<div><h4>Important Links</h4><ul><li><a href="privacy-policy.php">Privacy Policy</a></li><li><a href="refund-policy.php">Refund Policy</a></li><li><a href="terms-conditions.php">Terms &amp; Conditions</a></li></ul></div>
<div><h4>Quick Links</h4><ul><li><a href="about.php">About Us</a></li><li><a href="contact.php">Contact Us</a></li></ul></div>
<div><h4>Coaching Programs</h4><ul><li><a href="#">Online CLAT Coaching</a></li><li><a href="#">Online IPMAT Coaching</a></li><li><a href="#">Online CLAT PG Coaching</a></li><li><a href="#">Online Judiciary Coaching</a></li><li><a href="#">Online CUET Coaching</a></li></ul></div>
<div><h4>Contact US</h4>
<div class="ci-row"><span class="ci-ic"><img src="assets/images/map.svg" alt="Location"></span><span>1st Floor, EC - 22A, Shastri Circle, opp. Steel Bhawan, Adarsh Society, Sector-H, Shastri Nagar, Jodhpur, Rajasthan - 342003</span></div>
<div class="ci-row"><span class="ci-ic"><img src="assets/images/phone.svg" alt="Phone"></span><span>+91 7665944999</span></div>
<div class="ci-row"><span class="ci-ic"><img src="assets/images/mail.svg" alt="Email"></span><span>support@lawpreptutorial.com</span></div></div>
</div><div class="copy">Copyright 2026 <b>LPT Edtech Pvt. Ltd.</b> All Rights Reserved.</div></div></footer>
<div class="toast" id="toast"></div>
<script>
function toast(m){var t=document.getElementById('toast');t.textContent=m;t.style.display='block';setTimeout(function(){t.style.display='none'},2000)}
function addCart(id,qty){fetch('cart.php?add='+id+'&qty='+(qty||1)+'&ajax=1').then(r=>r.json()).then(d=>{var b=document.getElementById('cartBadge');b.textContent=d.count;b.style.display='inline-flex';toast(d.msg)})}
</script></body></html>
