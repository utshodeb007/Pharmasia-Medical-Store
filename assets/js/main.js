const nav = document.querySelector('.nav');

document.querySelector('.nav-toggle')?.addEventListener(
'click',
() => nav.classList.toggle('open')
);

const obs = new IntersectionObserver(
e => e.forEach(x => {
if (x.isIntersecting)
x.target.classList.add('show');
}),
{
threshold: .15
}
);

document.querySelectorAll('.reveal').forEach(
el => obs.observe(el)
);

document.querySelector('.top-btn')?.addEventListener(
'click',
() => scrollTo({
top: 0,
behavior: 'smooth'
})
);

addEventListener(
'scroll',
() => document.body.classList.toggle(
'scrolled',
scrollY > 40
)
);
