const scripts = {};

export default {
  include() {
    let c = 0;

    return new Promise(resolve => {
      const l = arguments.length;
      for (let i = 0; i < l; i++) {
        const url = arguments[i];
        const script = document.createElement('script');

        script.src = url;

        script.addEventListener('load', () => {
          c++;

          if (c === l) {
            resolve();
          }
        });

        scripts[url] = document.head.appendChild(script);
      }
    });
  },
  exclude() {
    const a = [];

    for (let i = 0; i < this.arguments.length; i++) {
      const url = this.arguments[i];

      if (delete scripts[url]) {
        a.push(url);
      }
    }

    return a;
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
