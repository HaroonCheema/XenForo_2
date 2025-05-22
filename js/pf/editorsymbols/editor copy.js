XF.on('editor:config', function(event, config, xfEditor) {
    let initialized = false;
    let loaded = false;
    let menu;
    let menuScroll;
    let scrollTop = 0;

    function showMenu() {
        selectionSave();
        XF.EditorHelpers.blur(xfEditor.ed);

        const btn = xfEditor.ed.$tb.querySelector('.fr-command[data-cmd="pfEsAddSymbol"]');
        if (!btn) return;

        if (!initialized) {
            initialized = true;

            const menuTemplate = document.querySelector('.js-editorPfEsSymbolsMenu');
            if (!menuTemplate) return;

            const menuHtml = Mustache.render(menuTemplate.innerHTML);
            menu = document.createElement('div');
            menu.innerHTML = menuHtml;
            menu = menu.firstElementChild;
            btn.parentNode.insertBefore(menu, btn.nextSibling);

            btn.dataset.xfClick = 'menu';

            const handler = XF.Event.getElementHandler(btn, 'menu', 'click');

            menu.addEventListener('menu:complete', function() {
                menuScroll = menu.querySelector('.menu-scroller');

                if (!loaded) {
                    loaded = true;

                    menuScroll.querySelectorAll('.js-psEsSymbol').forEach(symbol => {
                        symbol.addEventListener('click', insertSpecialChar);
                    });

                    xfEditor.ed.events.on('commands.mousedown', function($el) {
                        if ($el.dataset.cmd !== 'pfEsAddSymbol') {
                            handler.close();
                        }
                    });

                    menu.addEventListener('menu:closed', function() {
                        scrollTop = menuScroll.scrollTop;
                    });
                }

                menuScroll.scrollTop = scrollTop;
            });

            menu.addEventListener('menu:closed', function() {
                setTimeout(function() {
                    xfEditor.ed.markers.remove();
                }, 50);
            });
        }

        const clickHandlers = btn.dataset.xfClickHandlers;
        if (clickHandlers && clickHandlers.menu) {
            clickHandlers.menu.toggle();
        }
    }

    function insertSpecialChar(e) {
        const target = e.currentTarget;
        const html = target.innerHTML.trim();

        XF.EditorHelpers.focus(xfEditor.ed);
        xfEditor.ed.html.insert(html);
        selectionSave();
        XF.EditorHelpers.blur(xfEditor.ed);
    }

    function selectionSave() {
        xfEditor.ed.selection.save();
    }

    function selectionRestore() {
        xfEditor.ed.selection.restore();
    }

    // Register the editor button
    if (typeof FroalaEditor !== 'undefined') {
        // Define the icon
        FroalaEditor.DefineIcon('pfEsAddSymbol', { NAME: 'university' });

        // Register the command
        FroalaEditor.RegisterCommand('pfEsAddSymbol', {
            title: 'Insert Symbol',
            icon: 'pfEsAddSymbol',
            undo: false,
            focus: false,
            refreshOnCallback: false,
            callback: function() {
                showMenu();
            }
        });

        // Add the button to the toolbar
        if (config.buttons) {
            if (!config.buttons.includes('pfEsAddSymbol')) {
                config.buttons.push('pfEsAddSymbol');
            }
        }
    }
});