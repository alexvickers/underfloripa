(()=>{"use strict";var e,t,r={},o={};function n(e){var t=o[e];if(void 0!==t)return t.exports;var a=o[e]={exports:{}};return r[e](a,a.exports,n),a.exports}n.m=r,n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var r in t)n.o(t,r)&&!n.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},n.f={},n.e=e=>Promise.all(Object.keys(n.f).reduce(((t,r)=>(n.f[r](e,t),t)),[])),n.u=e=>e+".js",n.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),e={},t="magazine-blocks:",n.l=(r,o,a,i)=>{if(e[r])e[r].push(o);else{var l,s;if(void 0!==a)for(var u=document.getElementsByTagName("script"),d=0;d<u.length;d++){var p=u[d];if(p.getAttribute("src")==r||p.getAttribute("data-webpack")==t+a){l=p;break}}l||(s=!0,(l=document.createElement("script")).charset="utf-8",l.timeout=120,n.nc&&l.setAttribute("nonce",n.nc),l.setAttribute("data-webpack",t+a),l.src=r),e[r]=[o];var c=(t,o)=>{l.onerror=l.onload=null,clearTimeout(b);var n=e[r];if(delete e[r],l.parentNode&&l.parentNode.removeChild(l),n&&n.forEach((e=>e(o))),t)return t(o)},b=setTimeout(c.bind(null,void 0,{type:"timeout",target:l}),12e4);l.onerror=c.bind(null,l.onerror),l.onload=c.bind(null,l.onload),s&&document.head.appendChild(l)}},n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},(()=>{var e;n.g.importScripts&&(e=n.g.location+"");var t=n.g.document;if(!e&&t&&(t.currentScript&&(e=t.currentScript.src),!e)){var r=t.getElementsByTagName("script");if(r.length)for(var o=r.length-1;o>-1&&(!e||!/^http(s?):/.test(e));)e=r[o--].src}if(!e)throw new Error("Automatic publicPath is not supported in this browser");e=e.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),n.p=e})(),(()=>{var e={436:0};n.f.j=(t,r)=>{var o=n.o(e,t)?e[t]:void 0;if(0!==o)if(o)r.push(o[2]);else{var a=new Promise(((r,n)=>o=e[t]=[r,n]));r.push(o[2]=a);var i=n.p+n.u(t),l=new Error;n.l(i,(r=>{if(n.o(e,t)&&(0!==(o=e[t])&&(e[t]=void 0),o)){var a=r&&("load"===r.type?"missing":r.type),i=r&&r.target&&r.target.src;l.message="Loading chunk "+t+" failed.\n("+a+": "+i+")",l.name="ChunkLoadError",l.type=a,l.request=i,o[1](l)}}),"chunk-"+t,t)}};var t=(t,r)=>{var o,a,[i,l,s]=r,u=0;if(i.some((t=>0!==e[t]))){for(o in l)n.o(l,o)&&(n.m[o]=l[o]);s&&s(n)}for(t&&t(r);u<i.length;u++)a=i[u],n.o(e,a)&&e[a]&&e[a][0](),e[a]=0},r=self.webpackChunkmagazine_blocks=self.webpackChunkmagazine_blocks||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))})();const a=window.wp.domReady;n.n(a)()((()=>{n.e(353).then(n.bind(n,353)).then((({Splide:e})=>{new e(".splide",{perPage:1,pauseOnHover:!1,interval:2e3,type:"loop"}).mount()}));const{$$:e,each:t,toArray:r}=window.magazineBlocksUtils,o=e('[class*="mzb-slider"] .swiper');o.length&&n.e(350).then(n.bind(n,350)).then((({Navigation:e,Pagination:a,Autoplay:i,Keyboard:l})=>{n.e(100).then(n.bind(n,100)).then((({Swiper:n})=>{t(r(o),(t=>{var r,o,s,u;const d=JSON.parse(null!==(r=t.dataset?.swiper)&&void 0!==r?r:"{}");new n(t,{modules:[e,a,i,l],loop:!0,slidesPerView:"style3"===d.sliderStyle||"style4"===d.sliderStyle?d.slidesPerView:1,spaceBetween:20,speed:null!==(o=d.speed)&&void 0!==o?o:500,autoplay:!!d.autoplay&&{delay:5e3},navigation:!!d.arrows&&{nextEl:".swiper-button-next",prevEl:".swiper-button-prev"},pagination:null!==(s=d.pagination)&&void 0!==s&&s,keyboard:{enabled:!0},grabCursor:!1,simulateTouch:!1,createElements:null!==(u=d.arrows)&&void 0!==u&&u})}))}))}))}))})();