<?PHP
error_reporting(E_ALL ^ E_NOTICE);
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'applications';
			
	$app = new Application($_GET['id']);
	if(!$app->ok()) redirect('index.php');

	if(isset($_POST['btnSaveApp']))
	{
		
		$Error->blank($_POST['name'], 'Application Name');

		if($Error->ok())
		{
			$app                    = new Application($_GET['id']);
			$app->name              = $_POST['name'];
			$app->link              = $_POST['link'];
			$app->bundle_name       = $_POST['bundle_name'];
			$app->i_use_this_key    = $_POST['i_use_this_key'];
			$app->s3key             = $_POST['s3key'];
			$app->s3pkey            = $_POST['s3pkey'];
			$app->s3bucket          = $_POST['s3bucket'];
			$app->s3path            = $_POST['s3path'];
			$app->s3url             = $_POST['s3url'];
			$app->dirpath           = $_POST['dirpath'];
			$app->sparkle_key       = $_POST['sparkle_key'];
			$app->sparkle_pkey      = $_POST['sparkle_pkey'];
			$app->ap_key            = $_POST['ap_key'];
			$app->ap_pkey           = $_POST['ap_pkey'];
			$app->custom_salt       = $_POST['custom_salt'];
			$app->from_email        = $_POST['from_email'];
			$app->email_subject     = $_POST['email_subject'];
			$app->email_body        = $_POST['email_body'];
			$app->license_filename  = $_POST['license_filename'];
			$app->return_url        = $_POST['return_url'];
			$app->fs_security_key   = $_POST['fs_security_key'];
			$app->tweet_terms       = $_POST['tweet_terms'];
			$app->upgrade_app_id    = $_POST['upgrade_app_id'];
			$app->engine_class_name = $_POST['engine_class_name'];
			$app->update();
			redirect('application.php?id=' . $app->id);
			
		}
		else
		{
			$name              = $_POST['name'];
			$link              = $_POST['link'];
			$bundle_name       = $_POST['bundle_name'];
			$i_use_this_key    = $_POST['i_use_this_key'];
			$s3key             = $_POST['s3key'];
			$s3pkey            = $_POST['s3pkey'];
			$s3bucket          = $_POST['s3bucket'];
			$s3path            = $_POST['s3path'];
			$s3url             = $_POST['s3url'];
			$dirpath           = $_POST['dirpath'];
			$sparkle_key       = $_POST['sparkle_key'];
			$sparkle_pkey      = $_POST['sparkle_pkey'];
			$ap_key            = $_POST['ap_key'];
			$ap_pkey           = $_POST['ap_pkey'];
			$custom_salt       = $_POST['custom_salt'];
			$from_email        = $_POST['from_email'];
			$email_subject     = $_POST['email_subject'];
			$email_body        = $_POST['email_body'];
			$license_filename  = $_POST['license_filename'];
			$return_url        = $_POST['return_url'];
			$fs_security_key   = $_POST['fs_security_key'];
			$tweet_terms       = $_POST['tweet_terms'];
			$upgrade_app_id    = $_POST['upgrade_app_id'];
			$engine_class_name = $_POST['engine_class_name'];
		}
	}
	else
	{
		$name              = $app->name;
		$link              = $app->link;
		$bundle_name       = $app->bundle_name;
		$i_use_this_key    = $app->i_use_this_key;
		$s3key             = $app->s3key;
		$s3pkey            = $app->s3pkey;
		$s3bucket          = $app->s3bucket;
		$s3path            = $app->s3path;
        $s3url             = $app->s3url;
		$dirpath           = $app->dirpath;
		$sparkle_key       = $app->sparkle_key;
		$sparkle_pkey      = $app->sparkle_pkey;
		$ap_key            = $app->ap_key;
		$ap_pkey           = $app->ap_pkey;
		$custom_salt       = $app->custom_salt;
		$from_email        = $app->from_email;
		$email_subject     = $app->email_subject;
		$email_body        = $app->email_body;
		$license_filename  = $app->license_filename;
		$return_url        = $app->return_url;
		$fs_security_key   = $app->fs_security_key;
		$tweet_terms       = $app->tweet_terms;
		$upgrade_app_id    = $app->upgrade_app_id;
		$engine_class_name = $app->engine_class_name;
	}

	$upgrade_apps = DBObject::glob('Application', "SELECT * FROM shine_applications WHERE id <> '{$app->id}' ORDER BY name");

	$includes_path = DOC_ROOT . '/includes/';
	$files = scandir($includes_path);
	$available_engines = array();
	foreach($files as $fn)
	{
		$engine_name = match('/^class\.engine(..*?)\.php/', $fn, 1);
		if($engine_name !== false)
		{
			$available_engines[] = $engine_name;
		} 
	}
	$available_engines = implode(', ', $available_engines);
?>
<?PHP include('inc/header.inc.php'); ?>

<div class="row">
<div class="col-lg-12">

 <h1 class="page-header">Applications</h1>

<ul class="nav nav-pills">
    <li class="nav-link"><a class="nav-link active" href="application.php?id=<?PHP echo htmlspecialchars($app->id); ?>"><?PHP echo htmlspecialchars($app->name); ?></a></li>
    <li class="nav-link"><a class="nav-link" href="versions.php?id=<?PHP echo htmlspecialchars($app->id); ?>">Versions</a></li>
    <li class="nav-link"><a class="nav-link" href="version-new.php?id=<?PHP echo htmlspecialchars($app->id); ?>">Release New Version</a></li>
</ul>


<?PHP echo htmlspecialchars($Error); ?>


</div>

</div>

<form action="application.php?id=<?PHP echo htmlspecialchars($app->id); ?>" method="post">

<div class="row" style="margin-top: 20px;">
<div class="col-lg-12">


<div class="card">
<div class="card-header">
Basic Stuff
</div>

<div class="card-body">


<div class="form-group">
<label for="name">Application Name</label>
<input type="text" name="name" id="name" value="<?PHP echo htmlspecialchars($name); ?>" class="form-control">
</div>

<div class="form-group">
<label for="link">Base Download URL</label>
<input type="text" name="link" id="link" value="<?PHP echo htmlspecialchars($link); ?>" class="form-control">
<br>
<div class="alert alert-info">
<span class="info">Ex: Your application's base download url</span>
</div></div>


<div class="form-group">
<label for="dirpath">Base File Directory Path</label>
<input type="text" name="dirpath" id="dirpath" value="<?PHP echo htmlspecialchars($dirpath); ?>" class="form-control">
<br>
<div class="alert alert-info">
<span class="info">Ex: Your application's base upload file path</span>
</div></div>

<div class="form-group">
<label for="url">Bundle Name</label>
<input type="text" class="form-control" name="bundle_name" id="bundle_name" value="<?PHP echo htmlspecialchars($bundle_name); ?>">
<br>
<div class="alert alert-info">
<span class="info">Ex: MyApplication.app</span>
</div></div>

<div class="form-group">
<label for="url">i use this URL Key Slug</label>
<input type="text" class="form-control" name="i_use_this_key" id="i_use_this_key" value="<?PHP echo htmlspecialchars($i_use_this_key); ?>">
<br>
<div class="alert alert-info">
<span class="info">Ex: http://osx.iusethis.com/app/<strong>virtualhostx</strong></span>
</div></div>


<div class="form-group">
<label for="url">Twitter keywords to search for</label>
<input type="text" class="form-control" name="tweet_terms" id="tweet_terms" value="<?PHP echo htmlspecialchars($tweet_terms); ?>">
<br>
<div class="alert alert-info">
<span class="info">Seperate with commas</span>
</div>
</div>


<div class="form-group">
<label for="upgrade_app_id">Upgrade App</label><br>
                                    <select name="upgrade_app_id" id="upgrade_app_id" class="form-control">
										<option value="">-- None --</option>
										<?PHP foreach($upgrade_apps as $a) : ?>
										<option <?PHP if($upgrade_app_id == $a->id) echo 'selected="selected"'; ?> value="<?PHP echo htmlspecialchars($a->id); ?>"><?PHP echo htmlspecialchars($a->name); ?></option>
										<?PHP endforeach; ?>
									</select><br/>
<div class="alert alert-info">
<span class="info">Choosing an app here will provide a one-click option to upgrade existing orders to the selected app.</span>
</div></div>


</div>
</div>




<div class="card">
<div class="card-header">
File Storage
</div>

<div class="card-body">

<div class="form-group">
<label for="s3url">Amazon S3 URL</label>
<input type="text" class="form-control" name="s3url" id="s3url" value="<?PHP echo htmlspecialchars($s3url); ?>">
</div>

<div class="form-group">
<label for="s3key">Amazon S3 Key</label>
<input type="text" class="form-control" name="s3key" id="s3key" value="<?PHP echo htmlspecialchars($s3key); ?>">
</div>

<div class="form-group">
<label for="s3key">Amazon S3 Private Key</label>
<input type="text" class="form-control" name="s3pkey" id="s3pkey" value="<?PHP echo htmlspecialchars($s3pkey); ?>">
</div>


<div class="form-group">
<label for="s3key">Amazon S3 Bucket Name</label>
<input type="text" class="form-control" name="s3bucket" id="s3bucket" value="<?PHP echo htmlspecialchars($s3bucket); ?>">
</div>


<div class="form-group">
<label for="url">Amazon S3 Path</label>
<input type="text" class="form-control" name="s3path" id="s3path" value="<?PHP echo htmlspecialchars($s3path); ?>">
<br>
<div class="alert alert-info">
<span class="info">The directory in your bucket where you downloads will be stored</span>
</div>
</div>


</div>
</div>



<div class="card">
<div class="card-header">
Sparkle
</div>

<div class="card-body">

<div class="form-group">
<label for="sparkle_key">Sparkle Public Key</label>
<textarea name="sparkle_key" id="sparkle_key" class="form-control"><?PHP echo htmlspecialchars($sparkle_key) ?></textarea>
</div>

<div class="form-group">
<label for="sparkle_pkey">Sparkle Private Key</label>
<textarea name="sparkle_pkey" id="sparkle_pkey" class="form-control"><?PHP echo htmlspecialchars($sparkle_pkey) ?></textarea>
</div>



</div>
</div>



<div class="card">
<div class="card-header">
Licensing Engine
</div>

<div class="card-body">

<div class="form-group">
<label for="engine_class_name">License Engine Class Name</label><br>
<input type="text" class="form-control" name="engine_class_name" id="engine_class_name" value="<?PHP echo htmlspecialchars($engine_class_name); ?>">
<br>
<div class="alert alert-info">
<span class="info">The PHP class name of your licensing engine. Available engines are: <?PHP echo htmlspecialchars($available_engines); ?></span>
</div>
</div>

<div class="form-group">
<label for="ap_key">Aquatic Prime Public Key</label>
<textarea name="ap_key" id="ap_key" class="form-control"><?PHP echo htmlspecialchars($ap_key) ?></textarea>
</div>

<div class="form-group">
<label for="ap_pkey">Aquatic Prime Private Key</label>
<textarea name="ap_pkey" id="ap_pkey" class="form-control"><?PHP echo htmlspecialchars($ap_pkey) ?></textarea>
</div>

<div class="form-group">
<label for="custom_salt">Custom License Salt (if not using Aquatic Prime)</label>
<textarea name="custom_salt" id="custom_salt" class="form-control"><?PHP echo htmlspecialchars($custom_salt) ?></textarea>
</div>

</div>
</div>



<div class="card">
<div class="card-header">
PayPal
</div>

<div class="card-body">

<div class="form-group">
<label for="return_url">PayPal Thanks URL</label>
<input type="text" class="form-control" name="return_url" value="<?PHP echo htmlspecialchars($return_url); ?>" id="return_url">
</div>

</div>
</div>


<div class="card">
<div class="card-header">
FastSpring
</div>

<div class="card-body">

<div class="form-group">
<label for="return_url">Item Notification Security Key</label>
<input type="text" class="form-control" name="fs_security_key" value="<?PHP echo htmlspecialchars($fs_security_key); ?>" id="fs_security_key">
</div>

</div>
</div>



<div class="card">
<div class="card-header">
Thank-you Email
</div>

<div class="card-body">

<div class="form-group">
<label for="from_email">From Email</label>
<input type="text" class="form-control" name="from_email" value="<?PHP echo htmlspecialchars($from_email); ?>" id="from_email">
</div>

<div class="form-group">
<label for="email_subject">Email Subject</label>
<input type="text" class="form-control" name="email_subject" value="<?PHP echo htmlspecialchars($email_subject); ?>" id="email_subject">
</div>

<div class="form-group">
<label for="email_body">Email Body</label>
<textarea name="email_body" id="email_body" class="form-control"><?PHP echo htmlspecialchars($email_body) ?></textarea><br>
<div class="alert alert-info">
<span class="info"><strong>Available Substitutions</strong>: {first_name}, {last_name}, {payer_email}, {license}, {serial_number}, {1daylink}, {3daylink}, {1weeklink}, {foreverlink}. Add your own in includes/class.objects.php getBody().</span>
</div>
</div>

<div class="form-group">
<label for="license_filename">License Filename</label>
<input type="text" class="form-control" name="license_filename" value="<?PHP echo htmlspecialchars($license_filename); ?>" id="license_filename">
</div>

<input type="submit" name="btnSaveApp" value="Save Application" id="btnSaveApp" class="btn btn-lg btn-success btn-block">

</div>
</div>

</form>


</div>
</div>


<?PHP include('inc/footer.inc.php'); ?>
