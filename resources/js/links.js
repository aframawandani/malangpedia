const links = {};

export default {
  include() {
    let c = 0;

    return new Promise(resolve => {
      const l = this.arguments.length;
      for (let i = 0; i < l; i++) {
        const url = this.arguments[i];
        const link = document.createElement('link');

        link.type = 'text/css';
        link.href = url;
        link.rel = 'stylesheet';

        link.addEventListener('load', () => {
          c++;

          if (c === l) {
            resolve();
          }
        });

        links[url] = document.head.appendChild(link);
      }
    });
  },
  exclude() {
    const a = [];

    for (let i = 0; i < this.arguments.length; i++) {
      const url = this.arguments[i];

      if (delete links[url]) {
        a.push(url);
      }
    }

    return a;
  },
  excludeAll() {
    var urls = [];

    for (var url in links) {
      if (links[url] instanceof HTMLlinkElement) {
        urls.push(url);

        delete links[url];
      }
    }

    return urls;
  }
}
