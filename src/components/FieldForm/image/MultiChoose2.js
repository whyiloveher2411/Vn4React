import { FormControl, FormGroup, FormHelperText, FormLabel, IconButton, InputAdornment, InputLabel, makeStyles, OutlinedInput } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import Slide from '@material-ui/core/Slide';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
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
import { useAjax } from 'utils/useAjax';
import GoogleDrive from './GoogleDrive';



const Transition = React.forwardRef(function Transition(props, ref) {
    return <Slide direction="up" ref={ref} {...props} />;
});


const useStyles = makeStyles((theme) => ({
    appBar: {
        position: 'relative',
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
        gridTemplateColumns: "repeat(var(--columnNumber), auto)",
        gridAutoFlow: "row dense",
        '& .ghost': {
            border: '1px dashed #000',
            backgroundColor: '#ececec',
            '& *': {
                opacity: '0'
            }
        }
    },
    gridListItem: {
        width: '100%',
        height: '100%',
        objectFit: 'cover',
        border: '1px solid transparent',
        // width: 160,
        // flexShrink: 0,
        // height: 160,
        // display: 'inline-block',
        // margin: '0 5px',
        position: 'relative',
        '&:first-child': {
            gridArea: 'span 2/span 2',
        },
        '& .inside': {
            paddingTop: '100%',
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
        top: "50%", left: "50%", transform: "translate(-50%,-50%)"
    },

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
        let temp = post[name];
        temp.splice(index, 1);
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

    const getGridListCols = () => {
        if (window.innerWidth > 1440) {
            return 7;
        }

        if (window.innerWidth > 1280) {
            return 6;
        }

        if (window.innerWidth > 992) {
            return 5;
        }

        if (window.innerWidth > 768) {
            return 4;
        }

        if (window.innerWidth > 576) {
            return 3;
        }
        return 2;
    }

    const dragstart = () => {

        let section = document.getElementById('listImage' + name);

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
                        section.insertBefore(dragEl, next ? target.nextSibling : target);
                    }
                }
            }
        }

        function _onDragEnd() {
            if (section.dataset.eventIndex - indexEvent === 1) {
                newPos = [...section.children].map((child, index) => {
                    let data = document.getElementById(child.id).getBoundingClientRect();
                    data.index = child.dataset.index;
                    child.dataset.index = index;
                    child.id = 'div' + index;
                    return data;
                });

                dragEl.classList.remove('ghost');
                section.removeEventListener('dragover', _onDragOver, false);
                section.removeEventListener('dragend', _onDragEnd, false);

                if (nextEl !== dragEl.nextSibling) {

                    let temp = post[name];
                    let valueTemp = [];
                    newPos.forEach(item => {
                        valueTemp.push(temp[item.index]);
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

        <FormControl fullWidth>
            <FormLabel style={{ marginBottom: 5 }} component="legend">{config.title}</FormLabel>
            <FormGroup style={{ marginBottom: 5 }}>
                <div>
                    <Button
                        key='left'
                        variant="contained"
                        color="default"
                        startIcon={<PhotoLibraryOutlinedIcon />}
                        onClick={handleClickOpenSourceDialog}
                    >
                        Choose Image
                    </Button>
                </div>

                <DialogCustom
                    open={openSourDialog}
                    onClose={handleCloseSourceDialog}
                    title="Insert/edit image"
                    action={
                        <>
                            <Button onClick={handleCloseSourceDialog} color="default">
                                Cancel
                            </Button>
                            <Button onClick={handleOkSourceDialog} color="primary">
                                OK
                            </Button>
                        </>
                    }
                >
                    <Typography variant="body2" style={{ marginBottom: '1rem' }}>
                        You can insert a link directly from the input or select an existing file from the system by clicking the button icon at the end of the input field
                    </Typography>
                    <FormControl fullWidth variant="outlined">
                        <InputLabel htmlFor="outlined-adornment-password">Source (URL)</InputLabel>
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
                            label="Source (URL)"
                        />
                        <DrawerCustom
                            open={openFilemanagerDialog}
                            onClose={handleCloseFilemanagerDialog}
                            TransitionComponent={Transition}
                            titlePadding={0}
                            title={<div>
                                <Toolbar>
                                    <IconButton edge="start" color="inherit" onClick={handleCloseFilemanagerDialog} aria-label="close">
                                        <CloseIcon />
                                    </IconButton>
                                    <Typography variant="h4" className={classes.title}>
                                        File Mangage
                                    </Typography>
                                    <Button autoFocus color="inherit" onClick={handleSaveFilemanagerDialog}>
                                        save
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
            </FormGroup>
            < div
                className={classes.gridList}
                style={{ '--columnNumber': getGridListCols() }}
                id={'listImage' + name}
                draggable={false}
            >
                {post[name].map((ele, index) => <div data-index={index} id={'div' + index} key={index} draggable={true} className={classes.gridListItem + ' gridListItem '}>
                    <div className='inside'>
                        <IconButton onClick={() => handleClickRemoveImage(index)} size="small" className={classes.removeImg} aria-label="Remove Image" component="span">
                            <HighlightOffOutlinedIcon style={{ color: 'rgba(255,255,255,0.851)' }} />
                        </IconButton>
                        <img draggable={false} className={classes.image} src={validURL(ele.link) ? ele.link : process.env.REACT_APP_BASE_URL + ele.link} alt={'Image'} />
                    </div>
                </div>
                )}
            </div>

            < Alert icon={false} severity="info" >
                <p><strong>Multiple: </strong> You can select multiple images for this field</p>
                {
                    config.size &&
                    <>
                        <Typography variant="body1"><strong>Condition:</strong></Typography>
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
                        <p style={{ marginTop: 8 }}><strong>Thumbnail:</strong></p>
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
            <FormHelperText>{config.note}</FormHelperText>
            <LoadingCustom open={openLoadingCustom} style={{ zIndex: 1301 }} />
        </FormControl >
    )
}, (props1, props2) => {
    return JSON.stringify(props1.post[props1.name]) !== JSON.stringify(props2.post[props2.name]);
})