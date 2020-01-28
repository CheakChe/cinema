<footer>

</footer>
<? foreach ($var['scripts'] as $key => $script): ?>
    <script src="/app/public/js/<?= $script ?>.js"></script>
<? endforeach; ?>
</body>
</html>