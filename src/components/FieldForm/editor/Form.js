import { TextField, makeStyles, Typography, Slide, Toolbar, IconButton, Button, Avatar } from '@material-ui/core'
import { DrawerCustom, MaterialIcon } from 'components';
import React from 'react'
import { makeid } from 'utils/helper';
import GoogleDrive from '../image/GoogleDrive';
import ReactDOMServer from 'react-dom/server'
import EditWidget from 'components/EditWidget';
import { useSelector } from 'react-redux';

const useStyles = makeStyles((theme) => ({
    root: {
        '& .tox-editor-header': {
            width: 'var(--width)',
            zIndex: 1,
        },
        '& .tox-edit-area': {
            paddingTop: 'var(--toxHeaderHeight)',
        },
    },
    darkMode: {
        '& .tox .tox-menubar': {
            borderBottom: '1px solid ' + theme.palette.dividerDark,
        },
        '& .tox .tox-toolbar>*': {
            borderBottom: '1px solid ' + theme.palette.dividerDark,
            marginBottom: -1
        },
        '& .tox:not(.tox-tinymce-inline) .tox-editor-header': {
            borderBottom: '1px solid ' + theme.palette.dividerDark,
        },
        '& .tox .tox-menubar, & .tox .tox-toolbar,& .tox .tox-toolbar__overflow,& .tox .tox-toolbar__primary, & .tox .tox-statusbar, & .tox .tox-edit-area__iframe': {
            background: theme.palette.background.paper,
        },
        '& .tox-tinymce, & .tox:not([dir=rtl]) .tox-toolbar__group:not(:last-of-type), & .tox .tox-statusbar': {
            borderColor: theme.palette.dividerDark,
        },
        '& .tox .tox-mbtn, & .tox .tox-tbtn, & .tox .tox-statusbar a,& .tox .tox-statusbar__wordcount, & .tox .tox-statusbar__path-item, & .tox .tox-edit-area__iframe': {
            color: theme.palette.text.secondary,
            '--color': theme.palette.text.secondary,
            cursor: 'pointer',
        },
        '& .tox .tox-tbtn svg': {
            fill: theme.palette.text.secondary,
        },
        '& .tox .tox-tbtn:hover svg, & .tox .tox-tbtn--enabled svg, & .tox .tox-tbtn--enabled:hover svg, .tox .tox-tbtn:active svg,& .tox .tox-tbtn:focus:not(.tox-tbtn--disabled) svg': {
            fill: theme.palette.text.primary,
        },
        '& .tox .tox-mbtn:hover:not(:disabled):not(.tox-mbtn--active), & .tox .tox-tbtn:active, & .tox .tox-mbtn--active, & .tox .tox-mbtn:focus:not(:disabled), & .tox .tox-tbtn:hover, & .tox .tox-tbtn--enabled,& .tox .tox-tbtn--enabled:hover, &.tox .tox-tbtn:focus:not(.tox-tbtn--disabled)': {
            backgroundColor: theme.palette.background.selected,
            color: theme.palette.text.primary,
            cursor: 'pointer',
        }
    },
    editor: {
        '&>.MuiInputLabel-outlined.MuiInputLabel-shrink': {
            transform: 'translate(14px, -11px) scale(0.75)'
        },
        '&>.MuiInputBase-root>textarea, &>label': {
            lineHeight: 2.2
        },
        '&>.MuiOutlinedInput-root': {
            padding: 0,
        },
        '& .tox.tox-tinymce': {
            width: '100%',
            minHeight: 400,
        }
    },
    title: {
        marginLeft: theme.spacing(2),
        flex: 1,
        color: '#fff'
    },
}))

const Transition = React.forwardRef(function Transition(props, ref) {
    return <Slide direction="up" ref={ref} {...props} />;
});

export default React.memo(function TextareaForm(props) {

    const theme = useSelector(state => state.theme);

    const { config, post, name, onReview, ...rest } = props;
    const classes = useStyles()

    const [id, setId] = React.useState(false);

    const valueInital = post && post[name] ? post[name] : '';
    const [value, setValue] = React.useState(0);
    const [loadScript, setLoadScript] = React.useState(false);

    const filesActive = React.useState({});

    const [openFilemanagerDialog, setOpenFilemanagerDialog] = React.useState(false);
    const [fileType, setFileType] = React.useState([]);
    const [openWidgetDialog, setOpenWidgetDialog] = React.useState(false);

    const [widgetData, setWidgetData] = React.useState({});
    const [editor, setEditor] = React.useState(null);
    const widgets = React.useState(null);

    let interval;

    React.useEffect(() => {

        let id = 'editor_' + makeid(10, 'editor');

        while (document.getElementById(id)) {
            id = 'editor_' + makeid(10, 'editor');
        }

        setId(prev => id);

        if (!document.getElementById('tynymce')) {

            const script = document.createElement("script");
            script.id = 'tynymce';
            script.src = '/admin/tinymce/tinymce.min.js';
            script.async = true;

            script.onload = () => {
                setLoadScript(true);
            };
            document.body.appendChild(script);

        } else {

            if (!window.tinymce) {
                reloadEditor();
            } else {
                setLoadScript(true);
            }
        }

        return () => {
            window.tinymce?.get(id)?.remove();
        };

    }, []);

    const reloadEditor = () => {
        interval = setInterval(() => {
            if (window.tinymce) {
                setLoadScript(true);
                clearInterval(interval);
            }
        }, 10);
    }


    const handleCloseFilemanagerDialog = () => {
        setOpenFilemanagerDialog(false);
    };

    const handleClickOpenFilemanagerDialog = () => {
        setOpenFilemanagerDialog(true);
    };

    const handleOpenEditWidget = (editor) => {

        let node = editor.selection.getNode();

        let body = node.closest('body');

        body.querySelectorAll('.widget-selected').forEach(item => {
            item.classList.remove('widget-selected');
        });

        let data = {};

        if (node.classList.contains('widget')) {

            node.classList.add('widget-selected');

            data = JSON.parse(node.getAttribute('data'));

            if (!data) {
                data = {};
            }
        }

        setWidgetData(data);
        setOpenWidgetDialog(true);

    };

    React.useEffect(() => {

        if (loadScript) {

            if (!document.querySelector('#warperMain').classList.contains('hasEventScroll')) {
                document.querySelector('#warperMain').classList.add('hasEventScroll');
                document.querySelector('#warperMain').addEventListener('scroll', function () {

                    document.querySelectorAll('.warpper-editor').forEach(function (el) {

                        let $menubar = el.querySelector('.tox-editor-header');

                        if ($menubar) {

                            el.setAttribute('style', '--width:' + (el.offsetWidth - 2) + 'px; --toxHeaderHeight:' + $menubar.offsetHeight + 'px;');

                            let $tinymce_editor = el.querySelector('.tox-tinymce'),
                                top = el.getBoundingClientRect().top, dk = false;

                            if ($tinymce_editor.style.opacity == 1) {
                                dk = top + el.offsetHeight > 356 + $menubar.offsetHeight;
                            } else {
                                dk = top + el.offsetHeight > 356;
                            }

                            if (top <= 156 && dk) {
                                Object.assign($menubar.style, { position: 'fixed', top: 152 + 'px' });
                            } else {
                                Object.assign($menubar.style, { position: 'absolute', top: 'initial' });
                            }
                        }

                    });

                });
            }

            window.tinymce.init({
                selector: '#' + id,
                auto_resize: true,
                toolbar_sticky: true,
                // height: 800,
                verify_html: false,
                skin: 'oxide' + (theme.type === 'dark' ? '-dark' : ''),
                extended_valid_elements: true,
                fontsize_formats: "8px 10px 12px 14px 16px 18px 24px 36px 48px 72px",
                setup: function (editor) {

                    editor.on('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                    });

                    editor.on('dblclick', function (e) {
                        let element = editor.selection.getNode();

                        if (element.classList.contains('widget')) {
                            handleOpenEditWidget(editor);
                        }
                    });

                    editor.on('paste', function (e) {

                    });

                    editor.on('focusout', function (e) {
                        onReview(editor.getContent());
                    });

                    editor.on('change', function (e) {
                        editor.save();
                    });

                    editor.on('init', function (args) {
                        setEditor(editor);


                        var css = ':root { --color: ' + theme.palette.text.primary + ' }',
                            head = document.head || document.getElementsByTagName('head')[0],
                            style = document.createElement('style');

                        head.appendChild(style);

                        editor.dom.$('head').append(style);

                        style.type = 'text/css';

                        if (style.styleSheet) {
                            style.styleSheet.cssText = css;
                        } else {
                            style.appendChild(document.createTextNode(css));
                        }

                        // var scriptId = editor.dom.uniqueId();

                        // var scriptElm = editor.dom.create('script', {
                        //     id: scriptId,
                        //     type: 'text/javascript',
                        //     src: '/themes/vn4cms-ecommerce/scripts/uikit.js'
                        // });

                        // editor.getDoc().getElementsByTagName('head')[0].appendChild(scriptElm);
                    });


                    //Add Widget
                    editor.ui.registry.addIcon('widgetIcon', ReactDOMServer.renderToString(<MaterialIcon style={{ width: 24, height: 24 }} icon={{ custom: '<image style="width:100%;" href="/admin/images/page_builder_icon.svg"></image>' }} />));

                    editor.ui.registry.addButton('widget', {
                        icon: 'widgetIcon',
                        tooltip: 'Widget',
                        text: 'Widget',
                        onAction: () => {
                            handleOpenEditWidget(editor);
                        }
                    });
                },
                formats: {
                    underline: { inline: 'u', exact: true }
                },

                plugins: [
                    'autoresize advlist imagetools codesample powerpaste wordcount autolink template lists link image charmap print preview anchor codemirror searchreplace visualblocks help insertdatetime media table  biongFilemanager'
                ],
                codemirror: {
                    indentOnInit: true,
                    path: 'codemirror-4.8',
                    config: {
                        lineNumbers: true
                    }
                },
                toolbar: ['fontselect |  fontsizeselect | sizeselect | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent | link image biongFilemanager media | codesample code | removeformat widget'],
                codesample_languages: [
                    { text: 'HTML/XML', value: 'markup' },
                    { text: 'JavaScript', value: 'javascript' },
                    { text: 'CSS', value: 'css' },
                    { text: 'PHP', value: 'php' },
                    { text: 'Ruby', value: 'ruby' },
                    { text: 'Python', value: 'python' },
                    { text: 'Java', value: 'java' },
                    { text: 'C', value: 'c' },
                    { text: 'C#', value: 'csharp' },
                    { text: 'C++', value: 'cpp' }
                ],
                image_caption: true,
                file_browser_callback_types: 'file image media',
                automatic_uploads: false,
                autoresize_on_init: false,
                template_cdate_format: '[CDATE: %m/%d/%Y : %H:%M:%S]',
                template_mdate_format: '[MDATE: %m/%d/%Y : %H:%M:%S]',
                image_title: true,
                body_class: 'editor-content',
                powerpaste_word_import: 'prompt',
                powerpaste_html_import: 'prompt',
                content_css: [
                    '/article.css',
                ],
                // external_filemanager_path: process.env.REACT_APP_BASE_URL + 'filemanager/filemanager/',
                OpenFileManager: (type) => {
                    setFileType(type);
                    handleClickOpenFilemanagerDialog();
                },
                filemanager_title: "Quản lý file",
                external_plugins: {
                    "filemanager": "/admin/tinymce/plugins/biongFilemanager/ImageAddOn.js",
                    // "example": "/admin/js/tinymce/plugin/customplugin.js"
                },

            });
        }

    }, [loadScript]);

    const handleChooseFile = (file) => {
        window.__insertEditImageCallback(file.public_path, file);
        handleCloseFilemanagerDialog();
    }

    const handleChooseWidgetDialog = (file) => {
        setOpenWidgetDialog(false);
    }

    const handleEditWidget = (widget, html) => {

        let node = editor.selection.getNode();

        let nodeSelected = node.querySelector('.widget-selected');

        // let newElement = ReactDOMServer.renderToString(<div contentEditable={false} data={JSON.stringify(widget)} className="widget new-element"><MaterialIcon style={{ width: 16, marginRight: 5 }} icon={{ custom: '<image style="width:100%;" href="' + widgets[0][widgetData.__widget_type].icon + '" />' }} />{widget.__title}</div>);
        let newElement = ReactDOMServer.renderToString(<div contentEditable={false} data={JSON.stringify(widget)} className="widget new-element" dangerouslySetInnerHTML={{ __html: html }} />);

        if (nodeSelected) {
            nodeSelected.outerHTML = newElement;
        } else {
            editor.insertContent(newElement);
        }

        onReview(editor.getContent());

        let body = node.closest('body');
        body?.querySelectorAll('.widget-selected')?.forEach(item => {
            item.classList.remove('widget-selected');
        });
    }

    console.log('render EDITOR');
    if (id) {
        return (
            <>
                <Typography style={{ marginBottom: 4 }}>{config.title}</Typography>
                <div className={classes.root + " warpper-editor " + (theme.type === 'dark' ? classes.darkMode : '')} >
                    <TextField
                        fullWidth
                        multiline
                        className={classes.editor}
                        variant="outlined"
                        name={name}
                        value={valueInital}
                        label={''}
                        helperText={config.note}
                        id={id}
                        {...rest}
                        onBlur={e => { onReview(e.target.value) }}
                        onChange={e => { setValue(value + 1); post[name] = e.target.value }}
                    />
                    <DrawerCustom
                        open={openFilemanagerDialog}
                        onClose={handleCloseFilemanagerDialog}
                        TransitionComponent={Transition}
                        titlePadding={0}
                        title={
                            <Toolbar>
                                <IconButton edge="start" color="inherit" onClick={handleCloseFilemanagerDialog} aria-label="close">
                                    <MaterialIcon icon="Close" />
                                </IconButton>
                                <Typography variant="h4" className={classes.title}>
                                    File Mangage
                                </Typography>
                            </Toolbar>
                        }
                        width={1700}
                        restDialogContent={{
                            style: {
                                padding: 0
                            }
                        }}
                    >
                        <GoogleDrive values={post[name]} fileType={fileType} handleChooseFile={handleChooseFile} filesActive={filesActive} config={{}} />
                    </DrawerCustom>

                    <DrawerCustom
                        open={openWidgetDialog}
                        onClose={handleChooseWidgetDialog}
                        TransitionComponent={Transition}
                        titlePadding={0}
                        title={
                            <Toolbar>
                                <IconButton edge="start" color="inherit" onClick={handleChooseWidgetDialog} aria-label="close">
                                    <MaterialIcon icon="Close" />
                                </IconButton>
                                <Typography variant="h4" className={classes.title}>
                                    Edit Widget
                                </Typography>
                            </Toolbar>
                        }
                        restDialogContent={{
                            style: {
                                padding: 0,
                            }
                        }}
                    >
                        <EditWidget
                            post={widgetData}
                            editWiget={widgetData.__widget_type ? true : false}
                            widgets={{ data: widgets[0], set: widgets[1] }}
                            onSubmit={(html) => {
                                handleEditWidget(widgetData, html);
                                handleChooseWidgetDialog();
                            }}
                        />
                    </DrawerCustom>
                </div>
            </>
        )
    }
    return null;
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})
