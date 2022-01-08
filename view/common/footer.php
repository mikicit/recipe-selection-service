  <footer class="page__footer page-footer">
    <div class="page-footer__inner container-fluid">
      <div class="page-footer__copyright">
        <small>&copy; Copyright <?= date("Y"); ?>, hrecept.cz</small>
      </div>
    </div>
  </footer>
  <?php foreach($scripts as $script): ?>
  <script src="<?= $script['href']; ?>" <?= $script['attributes']; ?>></script>
  <?php endforeach; ?>
</body>
</html>