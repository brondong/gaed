<?php
	$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);

	$trans = $environment->getTranslator();
?>

<?php if ($paginator->getLastPage() > 1): ?>
	<ul class="pager">
		<?php
			echo $presenter->getNext($trans->trans('pagination.next'));

			echo '<input type="hidden" name="max" id="max" value="' . $paginator->getLastPage() . '" />';
		?>
	</ul>
<?php endif; ?>
