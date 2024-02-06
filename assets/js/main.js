/**
 * This function replaces all hrefs with the valid query version ie. ?page=home/ instead of /home/
 * @param {Array<HTMLAnchorElement>} links
 */
function replaceHrefs(links) {
    links.forEach(link => {
        const href = link.getAttribute('href');
        if (!href) return;
        if (href.startsWith('/')) {
            link.setAttribute('href', window.location.origin + '?page=' + href.slice(1));
        }
    });
}

replaceHrefs(document.querySelectorAll('a'));