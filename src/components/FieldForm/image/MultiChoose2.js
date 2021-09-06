import { AppBar, Dialog, FormControl, FormGroup, FormHelperText, FormLabel, IconButton, InputAdornment, InputLabel, makeStyles, OutlinedInput } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import Slide from '@material-ui/core/Slide';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import CloseIcon from '@material-ui/icons/Close';
import FolderOpenOutlinedIcon from '@material-ui/icons/FolderOpenOutlined';
import HighlightOffOutlinedIcon from '@material-ui/icons/HighlightOffOutlined';
import PhotoLibraryOutlinedIcon from '@material-ui/icons/PhotoLibraryOutlined';
import { Alert } from '@material-ui/lab';
import { updateRequireLogin } from 'actions/requiredLogin';
import { CircularCustom, DialogCustom, DrawerCustom, Loading as LoadingCustom } from 'components';
import { useSnackbar } from 'notistack';
import React from 'react';
import { DragDropContext, Draggable, Droppable } from 'react-beautiful-dnd';
import { useDispatch } from 'react-redux';
import { makeid, unCamelCase } from 'utils/helper';
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
        right: 3
    },
    gridList: {
        overflow: 'scroll',
        display: 'flex',
    },
    gridListItem: {
        width: 160,
        flexShrink: 0,
        height: 160,
        display: 'inline-block',
        margin: '0 5px',
        position: 'relative',
    }
}));

export default React.memo(function MultiChoose2(props) {

    const { config, post, name, onReview } = props;

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
    const [render, setRender] = React.useState(0);
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
        setValue({ link: inputDialog });
        setOpenSourDialog(false);
    }


    const handleClickOpenFilemanagerDialog = () => {
        setOpenFilemanagerDialog(true);
    };

    const handleCloseFilemanagerDialog = () => {

        onReview(post[name].filter(item => item.access !== false));
        setRender(render + 1);
        // setOpenSourDialog(false);
        setOpenFilemanagerDialog(false);

    };

    const handleSaveFilemanagerDialog = () => {

        console.log(filesActive[0]);

        let values = [];

        Object.keys(filesActive[0]).forEach(key => {
            values.push(filesActive[0][key]);
        });

        post[name] = values;
        onReview(values);
        setOpenSourDialog(false);
        setOpenFilemanagerDialog(false);
    };

    const handleClickRemoveImage = (index) => {
        let temp = post[name];
        temp.splice(index, 1);
        onReview(temp);
        setRender(render + 1);
    };

    const onDragEnd = (result) => {

        if (result.destination) {
            let temp = post[name];
            let [reorderItem] = temp.splice(result.source.index, 1);
            temp.splice(result.destination.index, 0, reorderItem);
            // post[name] = temp;

            onReview(temp);

        }

    };

    const validateImage = (linkImage, callback) => {

        if (linkImage && linkImage.link) {

            setOpenLoadingCustom(true);

            let img = new Image();

            let link = linkImage.link;
            let src = link;
            let type_link = 'local';

            if (validURL(link)) {
                if (!(link.search(process.env.APP_URL) > -1)) {
                    type_link = 'external';
                } else {
                    src = link;
                    link = link.replace(process.env.APP_URL, '/');
                }
            }

            img.onload = e => {

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
            return 6;
        }

        if (window.innerWidth > 1280) {
            return 5;
        }

        if (window.innerWidth > 992) {
            return 4;
        }

        if (window.innerWidth > 768) {
            return 3;
        }

        if (window.innerWidth > 576) {
            return 2;
        }
        return 1;
    }

    React.useEffect(() => {
        if (openFilemanagerDialog) {
            if (post[name]) {
                let filesActiveTemp = {};

                post[name].forEach(item => {
                    filesActiveTemp[item.link] = item;
                });

                filesActive[1](filesActiveTemp);
            }
        }
    }, [openFilemanagerDialog]);

    console.log('render IMAGE');
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
            {
                post[name].length > 0 &&
                <DragDropContext
                    onBeforeCapture={() => { }}
                    onBeforeDragStart={() => { }}
                    onDragStart={() => { }}
                    onDragUpdate={() => { }}
                    onDragEnd={onDragEnd}
                >
                    <Droppable droppableId={name} direction="horizontal">
                        {
                            (provided) => (
                                <div {...provided.droppableProps} ref={provided.innerRef} className={classes.gridList + ' custom_scroll'} cols={getGridListCols()}>
                                    {post[name].map((image, index) => (
                                        <Draggable key={index} draggableId={'_id' + index} index={index}>
                                            {
                                                (provided) => (
                                                    <div className={classes.gridListItem} {...provided.draggableProps} ref={provided.innerRef} {...provided.dragHandleProps}>
                                                        <IconButton style={{ background: 'rgba(32,33,36,0.6)' }} onClick={() => handleClickRemoveImage(index)} size="small" className={classes.removeImg} aria-label="Remove Image" component="span">
                                                            <HighlightOffOutlinedIcon style={{ color: 'rgba(255,255,255,0.851)' }} />
                                                        </IconButton>
                                                        <img style={{ width: '100%', height: '100%', objectFit: 'cover' }} src={image.type_link === 'local' ? image.link : image.link} alt={'sdfsdfsdf'} />
                                                    </div>
                                                )
                                            }
                                        </Draggable>
                                    ))}
                                    {provided.placeholder}
                                </div>
                            )
                        }
                    </Droppable>
                </DragDropContext>
            }
            <Alert icon={false} severity="info">
                <Typography variant="body1"><strong>Multiple: </strong> You can select multiple images for this field</Typography>
                {
                    config.size &&
                    <>
                        <Typography variant="body1"><strong>Condition:</strong></Typography>
                        {
                            Object.keys(config.size).map(key => (
                                <Typography variant="body2" key={key}><strong>&nbsp;&nbsp;&nbsp;&nbsp;{unCamelCase(key)}:</strong> {config.size[key]}{key !== "ratio" ? "px" : ""}</Typography>
                            ))
                        }
                    </>
                }
                {
                    config.thumbnail &&
                    <>
                        <Typography variant="body1" style={{ marginTop: 8 }}><strong>Thumbnail:</strong></Typography>
                        {
                            Object.keys(config.thumbnail).map(key => (
                                <Typography variant="body2" key={key}>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>{unCamelCase(key)}:&nbsp;</strong>
                                    {
                                        Object.keys(config.thumbnail[key]).map(key2 => unCamelCase(key2) + ': ' + config.thumbnail[key][key2] + 'px; ')
                                    }
                                </Typography>
                            ))
                        }
                    </>
                }
            </Alert>
            <FormHelperText>{config.note}</FormHelperText>
            <LoadingCustom open={openLoadingCustom} style={{ zIndex: 1301 }} />
        </FormControl >
    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})