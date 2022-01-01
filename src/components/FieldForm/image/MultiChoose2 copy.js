import { Box, FormControl, FormGroup, FormHelperText, FormLabel, IconButton, InputAdornment, InputLabel, makeStyles, OutlinedInput } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import Slide from '@material-ui/core/Slide';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import CloudUpload from '@material-ui/icons/CloudUpload';
import CloseIcon from '@material-ui/icons/Close';
import FolderOpenOutlinedIcon from '@material-ui/icons/FolderOpenOutlined';
import HighlightOffOutlinedIcon from '@material-ui/icons/HighlightOffOutlined';
import PhotoLibraryOutlinedIcon from '@material-ui/icons/PhotoLibraryOutlined';
import { Alert } from '@material-ui/lab';
import { DialogCustom, DrawerCustom, Loading as LoadingCustom } from 'components';
import { useSnackbar } from 'notistack';
import React from 'react';
import { unCamelCase } from 'utils/helper';
import { validURL } from 'utils/herlperUrl';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import GoogleDrive from './GoogleDrive';
import { addClasses } from 'utils/dom';



const Transition = React.forwardRef(function Transition(props, ref) {
    return <Slide direction="up" ref={ref} {...props} />;
});

const useStyles = makeStyles((theme) => ({
    appBar: {
        position: 'relative',
    },
    toolbar: {
        '& .MuiButton-root': {
            color: 'white',
        }
    },
    title: {
        marginLeft: theme.spacing(2),
        flex: 1,
        color: '#fff'
    },
    removeImg: {
        position: 'absolute',
        top: 3,
        right: 3,
        zIndex: 2,
        background: 'rgba(32,33,36,0.6)',
        '&:hover': {
            background: 'rgba(32,33,36,0.8)',
        }
    },
    gridList: {
        padding: "0",
        listStyle: "none",
        WebkitUserSelect: "none",
        MozUserSelect: "none",
        userSelect: "none",
        display: "grid",
        gridGap: "5px",
        gridTemplateColumns: "repeat(auto-fill, 160px)",
        gridAutoFlow: "row dense",
        '& .ghost': {
            border: '1px dashed #000',
            backgroundColor: '#ececec',
            '& *': {
                opacity: '0'
            }
        }
    },
    noGrid: {
        display: 'block',
    },
    gridListItem: {
        width: '100%',
        height: '100%',
        objectFit: 'cover',
        border: '1px solid transparent',
        position: 'relative',
        '&:first-child': {
            gridArea: 'span 2/span 2',
        },
        '& .inside': {
            paddingTop: '100%',
        },
        '&:not(.uploadFile)': {
            cursor: 'move'
        }
    },
    image: {
        width: '100%',
        height: '100%',
        objectFit: 'cover',
        position: 'absolute',
        bottom: 0,
        right: 0,
        zIndex: 1,
        top: "50%", left: "50%", transform: "translate(-50%,-50%)",
        backgroundImage: 'url(/admin/fileExtension/trans.jpg)'
    },
    uploadArea: {
        border: '2px dashed rgb(140, 145, 150)',
        minHeight: 160,
        minWidth: 160,
        borderRadius: 7,
        cursor: 'pointer',
        '&:hover': {
            backgroundColor: theme.palette.dividerDark
        }
    }
}));

export default React.memo(function MultiChoose2(props) {

    const { config, post, name } = props;

    const classes = useStyles();

    const [openSourDialog, setOpenSourDialog] = React.useState(false);
    const [openFilemanagerDialog, setOpenFilemanagerDialog] = React.useState(false);

    const { enqueueSnackbar } = useSnackbar();
    const { ajax } = useAjax();

    let valueInital = [];

    try {
        if (typeof post[name] === 'object') {
            valueInital = post[name];
        } else {
            if (post[name]) {
                valueInital = JSON.parse(post[name]);
            }
        }
    } catch (error) {
        valueInital = [];
    }

    if (!valueInital) valueInital = [];

    post[name] = valueInital;

    const [value, setValue] = React.useState(valueInital);
    const [inputDialog, setInputDialog] = React.useState(valueInital);
    const [openLoadingCustom, setOpenLoadingCustom] = React.useState(false);

    const filesActive = React.useState({});

    const handleClickOpenSourceDialog = () => {
        setInputDialog(post[name]);
        setOpenSourDialog(true);
    };

    const handleCloseSourceDialog = () => {
        setOpenSourDialog(false);
    };

    const handleOkSourceDialog = () => {
        // setValue({ link: inputDialog });
        setOpenSourDialog(false);
    }

    const onReview = (value) => {
        post[name] = [...value];
        setValue(value);
        props.onReview([...value]);
    }

    const handleClickOpenFilemanagerDialog = () => {
        filesActive[1](() => {
            let filesActiveTemp = {};
            value.forEach((item, index) => {
                filesActiveTemp[item.link] = { ...item, index: index };
            });
            return filesActiveTemp;
        });
        setOpenFilemanagerDialog(true);
    };

    const handleCloseFilemanagerDialog = () => {

        onReview(post[name]);
        // setOpenSourDialog(false);
        setOpenFilemanagerDialog(false);

    };

    const handleSaveFilemanagerDialog = () => {

        let images = [];

        Object.keys(filesActive[0]).forEach(key => {
            let index = filesActive[0][key].index;
            // delete filesActive[0][key].index;
            if (!(index > -1)) {
                images.push({
                    ...filesActive[0][key]
                });
            }
        });

        let valueTemp = [...post[name], ...images];
        let valueTemp2 = [...value, ...images];
        onReview(valueTemp);
        setTimeout(() => {
            onReview(valueTemp2);
        }, 0);
        setOpenSourDialog(false);
        setOpenFilemanagerDialog(false);
        dragstart();
    };

    const handleClickRemoveImage = (index) => {
        let temp = [...post[name]];
        temp.splice(index, 1);
        console.log(post[name]);

        onReview(temp);
    };

    const validateImage = (linkImage, callback) => {

        if (linkImage && linkImage.link) {

            setOpenLoadingCustom(true);

            let img = new Image();

            let link = linkImage.link;
            let src = link;
            let type_link = 'local';

            if (validURL(link)) {
                if (link.search(process.env.REACT_APP_BASE_URL) > -1) {
                    src = link;
                    link = link.replace(process.env.REACT_APP_BASE_URL, '/');
                } else {
                    type_link = 'external';
                }
            }

            img.onload = () => {

                let data = {
                    link: link,
                    type_link: type_link,
                    ext: linkImage.link.split('.').pop(),
                    width: img.width,
                    height: img.height
                };

                const conditionFunc = {
                    width: (value) => img.width === value ? true : 'Width: ' + value + 'px',
                    minWidth: (value) => img.width >= value ? true : 'Min Width: ' + value + 'px',
                    maxWidth: (value) => img.width <= value ? true : 'Max Width: ' + value + 'px',
                    height: (value) => img.height === value ? true : 'Height: ' + value + 'px',
                    minHeight: (value) => img.height >= value ? true : 'Min Height: ' + value + 'px',
                    maxHeight: (value) => img.height <= value ? true : 'Max Height: ' + value + 'px',
                    ratio: (value) => {
                        let ratio = value.split(':');
                        if (img.width / img.height !== ratio[0] / ratio[1]) {
                            return 'Ratio: ' + value;
                        }
                        return true;
                    }
                };

                if (config.size) {

                    let messages = [];

                    Object.keys(config.size).forEach(key => {
                        if (conditionFunc[key]) {
                            let check = conditionFunc[key](config.size[key]);
                            if (check !== true) {
                                messages.push(check);
                            }
                        }
                    });

                    if (messages.length > 0) {
                        enqueueSnackbar({
                            content: 'The image is not the correct size specified',
                            note: { time: new Date(), content: messages.map((m, index) => <Typography key={index} variant="body1">{m}</Typography>) },
                            type: 'note',
                            options: { preventDuplicate: false, variant: 'error', anchorOrigin: { vertical: 'bottom', horizontal: 'left' } }
                        },
                            { preventDuplicate: false, variant: 'error', anchorOrigin: { vertical: 'bottom', horizontal: 'left' } }
                        );
                        setOpenLoadingCustom(false);
                        callback({});
                        return;
                    }
                }

                if (config.thumbnail) {

                    ajax({
                        url: 'image/thumbnail',
                        method: 'POST',
                        isGetData: false,
                        data: {
                            thumbnail: config.thumbnail,
                            data: data,
                        },
                        success: (result) => {
                            if (result.link) {
                                callback(result);
                                setOpenLoadingCustom(false);
                            }
                        }
                    });

                } else {
                    callback(data);
                    setOpenLoadingCustom(false);
                }

            };

            img.onerror = () => {
                setOpenLoadingCustom(false);
            }

            img.src = decodeURIComponent(src);

        } else {
            callback({});
        }
    }

    const handleChooseFile = (file) => {

        validateImage({ link: file.public_path }, (result) => {
            if (result.link) {

                if (filesActive[0]['/' + file.dirpath + '/' + file.basename]) {
                    delete filesActive[0]['/' + file.dirpath + '/' + file.basename];
                    filesActive[1]({ ...filesActive[0] });
                } else {
                    filesActive[0]['/' + file.dirpath + '/' + file.basename] = result;
                    filesActive[1]({ ...filesActive[0] });
                }
            }
        });
    }


    const dragstart = () => {

        let section = document.getElementById('listImage' + name);

        if (!section) return;

        let indexEvent = section.dataset.eventIndex || 0;

        if (!section.dataset.eventIndex) {
            section.dataset.eventIndex = 1;
        } else {
            section.dataset.eventIndex = parseInt(section.dataset.eventIndex) + 1;
        }

        let dragEl, nextEl, newPos;

        function _onDragOver(e) {

            if (section.dataset.eventIndex - indexEvent === 1) {
                e.dataTransfer.dropEffect = 'move';

                let target = e.currentTarget;

                if (target && target !== dragEl && target.nodeName == 'DIV') {
                    if (target.classList.contains('inside')) {
                        e.stopPropagation();
                    } else {
                        let targetPos = target.getBoundingClientRect();
                        let next = (e.clientY - targetPos.top) / (targetPos.bottom - targetPos.top) > .5 || (e.clientX - targetPos.left) / (targetPos.right - targetPos.left) > .5;

                        if (!target.classList.contains('uploadFile')) {
                            section.insertBefore(dragEl, next ? target.nextSibling : target);
                        }
                    }
                }
            }

        }

        function _onDragEnd() {
            if (section.dataset.eventIndex - indexEvent === 1) {
                newPos = [...section.children].map((child, index) => {
                    if (child.id) {
                        let data = document.getElementById(child.id).getBoundingClientRect();
                        data.index = child.dataset.index;
                        child.dataset.index = index;
                        child.id = 'div' + index;
                        return data;
                    }
                });

                dragEl.classList.remove('ghost');
                section.removeEventListener('dragover', _onDragOver, false);
                section.removeEventListener('dragend', _onDragEnd, false);

                if (nextEl !== dragEl.nextSibling) {

                    let temp = post[name];
                    let valueTemp = [];
                    newPos.forEach(item => {
                        if (item) {
                            valueTemp.push(temp[item.index]);
                        }
                    });
                    onReview(valueTemp);
                }
            }
        }

        section.addEventListener('dragstart', function (e) {
            if (section.dataset.eventIndex - indexEvent === 1) {
                e.stopPropagation();
                dragEl = e.target;
                nextEl = dragEl.nextSibling;

                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('Text', dragEl.textContent);

                section.querySelectorAll('.gridListItem').forEach(element => {
                    element.addEventListener('dragover', _onDragOver, false);
                });

                section.addEventListener('dragend', _onDragEnd, false);

                setTimeout(function () {
                    dragEl.classList.add('ghost');
                }, 0)
            }
        });
    }

    React.useEffect(() => {
        if (document.getElementById('listImage' + name)) {
            dragstart();
        }
        onReview(post[name]);
    }, []);

    return (
        <>
            <FormControl fullWidth>
                {
                    Boolean(config.customUploadArea) ?
                        <config.customUploadArea
                            config={config}
                            openDialog={handleClickOpenSourceDialog}
                            post={post}
                            ImageResult={<ImageResult
                                config={config}
                                classes={classes}
                                post={post}
                                handleClickRemoveImage={handleClickRemoveImage}
                                handleClickOpenSourceDialog={handleClickOpenSourceDialog}
                                name={name}
                            />}
                            Note={
                                <Note config={config} />
                            }
                        />
                        :
                        <>
                            <FormLabel style={{ marginBottom: 5 }} component="legend">{config.title}</FormLabel>
                            < div
                                className={addClasses({
                                    [classes.gridList]: true,
                                    [classes.noGrid]: Boolean(!post[name] || post[name].length < 1)
                                })}
                                id={'listImage' + name}
                                draggable={false}
                            >
                                <ImageResult
                                    config={config}
                                    classes={classes}
                                    post={post}
                                    handleClickRemoveImage={handleClickRemoveImage}
                                    handleClickOpenSourceDialog={handleClickOpenSourceDialog}
                                    name={name}
                                />
                            </div>
                            <Note config={config} />
                        </>
                }
                <FormHelperText>{config.note}</FormHelperText>
                <LoadingCustom open={openLoadingCustom} style={{ zIndex: 1301 }} />
            </FormControl >
            <DialogCustom
                open={openSourDialog}
                onClose={handleCloseSourceDialog}
                title="Insert/edit image"
                action={
                    <>
                        <Button onClick={handleCloseSourceDialog} color="default">
                            {__('Cancel')}
                        </Button>
                        <Button onClick={handleOkSourceDialog} color="primary">
                            {__('OK')}
                        </Button>
                    </>
                }
            >
                <Typography variant="body2" style={{ marginBottom: '1rem' }}>
                    {__('You can insert a link directly from the input or select an existing file from the system by clicking the button icon at the end of the input field')}
                </Typography>
                <FormControl fullWidth variant="outlined">
                    <InputLabel htmlFor="outlined-adornment-password">{__('Source (URL)')}</InputLabel>
                    <OutlinedInput
                        fullWidth
                        type='text'
                        value={unescape(inputDialog.length ? JSON.stringify(inputDialog) : '')}
                        onChange={e => setInputDialog(e.target.value)}
                        endAdornment={
                            <InputAdornment position="end">
                                <IconButton
                                    aria-label="Open Filemanager"
                                    edge="end"
                                    onClick={handleClickOpenFilemanagerDialog}
                                >
                                    <FolderOpenOutlinedIcon />
                                </IconButton>
                            </InputAdornment>
                        }
                        label={__('Source (URL)')}
                    />
                    <DrawerCustom
                        open={openFilemanagerDialog}
                        onClose={handleCloseFilemanagerDialog}
                        TransitionComponent={Transition}
                        titlePadding={0}
                        title={<div>
                            <Toolbar className={classes.toolbar}>
                                <IconButton onClick={handleCloseFilemanagerDialog} aria-label="close">
                                    <CloseIcon />
                                </IconButton>
                                <Typography variant="h4" className={classes.title}>
                                    {__('File Mangage')}
                                </Typography>
                                <Button autoFocus onClick={handleSaveFilemanagerDialog}>
                                    {__('Save Changes')}
                                </Button>
                            </Toolbar>
                        </div>}
                        width={1700}
                        restDialogContent={{
                            style: {
                                padding: 0
                            }
                        }}
                    >
                        <GoogleDrive values={post[name]} handleChooseFile={handleChooseFile} fileType={'ext_image'} filesActive={filesActive} config={config} />
                    </DrawerCustom>
                </FormControl>
            </DialogCustom>
        </>
    )
}, (props1, props2) => {
    return JSON.stringify(props1.post[props1.name]) !== JSON.stringify(props2.post[props2.name]);
})

const ImageResult = ({ config, classes, post, handleClickRemoveImage, handleClickOpenSourceDialog, name }) => {
    return <>
        {post[name].map((ele, index) => <div data-index={index} id={'div' + index} key={index} draggable={true} className={classes.gridListItem + ' gridListItem '}>
            <div className='inside'>
                <IconButton onClick={() => handleClickRemoveImage(index)} size="small" className={classes.removeImg} aria-label="Remove Image" component="span">
                    <HighlightOffOutlinedIcon style={{ color: 'rgba(255,255,255,0.851)' }} />
                </IconButton>
                <img draggable={false} className={classes.image} src={validURL(ele.link) ? ele.link : process.env.REACT_APP_BASE_URL + ele.link} alt={'Image'} />
            </div>
        </div>
        )}
        <div draggable={false} className={classes.gridListItem + ' gridListItem uploadFile'}>
            <div className='inside' style={{ paddingTop: 0 }}>
                <Box onClick={handleClickOpenSourceDialog} display="flex" alignItems="center" justifyContent="center" padding={2} className={classes.uploadArea} style={{ height: 'auto', width: 'auto' }} >
                    <Box display="flex" flexDirection="column" gridGap={8} alignItems="center">
                        <CloudUpload fontSize="large" />
                        <Button variant="contained">{__('Add Images')}</Button>
                    </Box>
                </Box>
            </div>
        </div>
    </>
};

const Note = ({ config }) => {

    if (config.size || config.thumbnail) {
        return <Alert icon={false} severity="info" >
            {
                config.size &&
                <>
                    <Typography variant="body1"><strong>{__('Condition')}:</strong></Typography>
                    {
                        Object.keys(config.size).map(key => (
                            <p key={key}><strong>&nbsp;&nbsp;&nbsp;&nbsp;{unCamelCase(key)}:</strong> {config.size[key]}{key !== "ratio" ? "px" : ""}</p>
                        ))
                    }
                </>
            }
            {
                config.thumbnail &&
                <>
                    <p style={{ marginTop: 8 }}><strong>{__('Auto crop photo')}:</strong></p>
                    {
                        Object.keys(config.thumbnail).map(key => (
                            <p key={key}>
                                &nbsp;&nbsp;&nbsp;&nbsp;<strong>{unCamelCase(key)}:&nbsp;</strong>
                                {
                                    Object.keys(config.thumbnail[key]).map(key2 => unCamelCase(key2) + ': ' + config.thumbnail[key][key2] + 'px; ')
                                }
                            </p>
                        ))
                    }
                </>
            }
        </Alert >
    }

    return null;
}