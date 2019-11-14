document.addEventListener('DOMContentLoaded', function() {
    let modalElems = document.querySelectorAll('.modal');
    let modalInstances = M.Modal.init(modalElems);

    let tabsElems = document.querySelectorAll(".tabs");
    let tabsInstances = M.Tabs.init(tabsElems);

    let sidenavElems = document.querySelectorAll('.sidenav');
    let sidenavInstances = M.Sidenav.init(sidenavElems);
    
    let collapsibleElems = document.querySelectorAll('.collapsible');
    let collapsibleInstances = M.Collapsible.init(collapsibleElems);
});