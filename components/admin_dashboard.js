 const body = document.querySelector('body'),
      sidebar = body.querySelector('.sidebar'),
      main = body.querySelector('main'),
      toggle = body.querySelector('.toggle'),
      modeSwitch = body.querySelector('.toggle-switch'),
      modeText = body.querySelector('.mode-text');

// Check saved theme on page load
if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark');
    modeText.innerText = 'Light Mode';
} else {
    modeText.innerText = 'Dark Mode';
}

toggle.addEventListener('click', () => {
  sidebar.classList.toggle('close');
})

modeSwitch.addEventListener('click', () => {
  body.classList.toggle('dark');

  if(body.classList.contains('dark')) {
      modeText.innerText = 'Light Mode';
      localStorage.setItem('theme', 'dark');
  } else {
    modeText.innerText = 'Dark Mode'
    localStorage.setItem('theme', 'light');
  }
});

