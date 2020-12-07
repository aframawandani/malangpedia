const scripts = {};

export default {
  include(url) {
    const script = document.createElement('script');

    const promise = new Promise((resolve, reject) => {
      script.addEventListener('load', resolve);
      script.addEventListener('error', reject);
    });

    script.src = url;

    scripts[url] = document.head.appendChild(script);

    return promise;
  },
  exclude(url) {
    delete scripts[url];

    return url;
  },
  excludeAll() {
    var urls = [];

    for (var url in scripts) {
      if (scripts[url] instanceof HTMLScriptElement) {
        urls.push(url);

        delete scripts[url];
      }
    }

    return urls;
  }
}
