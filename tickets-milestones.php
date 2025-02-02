<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'tickets';

	$app = new Application($_GET['app_id']);
	if(!$app->ok()) redirect('tickets.php');

	$milestones = DBObject::glob('milestone', "SELECT * FROM shine_milestones WHERE app_id = '{$app->id}' ORDER BY dt_due ASC");
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">

                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2><?PHP echo htmlspecialchars($a->name); ?> Ticket Summary</h2>
							<ul>
								<li><a href="tickets-app-summary.php?id=<?PHP echo htmlspecialchars($app->id); ?>"><?PHP echo htmlspecialchars($app->name); ?> Summary</a></li>
								<li><a href="tickets-tickets.php?app_id=<?PHP echo htmlspecialchars($app->id); ?>">Tickets</a></li>
								<li class="active"><a href="tickets-milestones.php?app_id=<?PHP echo htmlspecialchars($app->id); ?>">Milestones</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
							<table>
                                <thead>
                                    <tr>
										<td>Title</td>
										<td>Due</td>
										<td>Progres</td>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($milestones as $m): ?>
									<tr>
										<td><a href="tickets-milestone.php?id=<?PHP echo htmlspecialchars($m->id); ?>"><?PHP echo htmlspecialchars($m->title); ?></a></td>
										<td><?PHP echo htmlspecialchars(dater($m->dt_due, 'F j')); ?></td>
										<td><span class="pbar"><span class="inner" style="width:<?PHP echo htmlspecialchars($m->percent()); ?>%;"></span><span class="percent"><?PHP echo htmlspecialchars($m->percent()); ?>%</span></span></td>
									</tr>
									<?PHP endforeach; ?>
                                </tbody>
                            </table>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
				<div class="block">
					<div class="hd"><h3>Create a New Item</h3></div>
					<div class="bd">
						<p class="text-center"><a href="tickets-new.php?app_id=<?PHP echo htmlspecialchars($app->id); ?>" class="big-button">New Ticket</a></p>
						<p class="text-center"><a href="tickets-milestone-new.php?app_id=<?PHP echo htmlspecialchars($app->id); ?>" class="big-button">New Milestone</a></p>
					</div>
				</div>
            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>
