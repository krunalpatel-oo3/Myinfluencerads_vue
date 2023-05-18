<template>
  <div>
    <header class="header-slot">
      <slot name="header"></slot>
    </header>
    <main class="main-slot">
      <slot></slot>
    </main>
    <footer class="footer-slot">
      <slot name="footer"></slot>
      <div class="np-credits">wwww.nightprogrammer.com</div>
    </footer>
  </div>
</template>