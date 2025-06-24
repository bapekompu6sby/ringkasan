// Here goes your custom javascript
// -----------------------------------------------------------------------------
function tabclick($id) {
    const theTab = document.getElementById($id);
    // theTab.setAttribute("class", "active");
    if (theTab.hasAttribute("class")) {
        theTab.setAttribute("class", "nav-link fade active show");
    }
}