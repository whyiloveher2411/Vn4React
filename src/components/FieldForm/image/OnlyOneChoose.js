import { AppBar, CardMedia, Dialog, FormControl, FormGroup, FormHelperText, FormLabel, IconButton, InputAdornment, InputLabel, makeStyles, OutlinedInput } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import Slide from '@material-ui/core/Slide';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import CloseIcon from '@material-ui/icons/Close';
import FolderOpenOutlinedIcon from '@material-ui/icons/FolderOpenOutlined';
import HighlightOffOutlinedIcon from '@material-ui/icons/HighlightOffOutlined';
import ImageOutlined from '@material-ui/icons/ImageOutlined';
import { Alert } from '@material-ui/lab';
import { updateRequireLogin } from 'actions/requiredLogin';
import { CircularCustom, DialogCustom, DrawerCustom, Loading as LoadingCustom } from 'components';
import { useSnackbar } from 'notistack';
import React from 'react';
import { useDispatch } from 'react-redux';
import { makeid, unCamelCase } from 'utils/helper';
import { validURL } from 'utils/herlperUrl';
import { useAjax } from 'utils/useAjax';


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
    }
}));

export default React.memo(function ImageForm(props) {

    const { config, post, name, onReview } = props;

    const classes = useStyles();

    const [loadingFileManage, setLoadingFileManage] = React.useState(true);
    const [openSourDialog, setOpenSourDialog] = React.useState(false);
    const [openFilemanagerDialog, setOpenFilemanagerDialog] = React.useState(false);

    const { enqueueSnackbar } = useSnackbar();
    const { ajax } = useAjax();

    const dispatch = useDispatch();

    let valueInital = {};

    try {
        if (typeof post[name] === 'object') {
            valueInital = post[name];
        } else {
            if (post[name]) {
                valueInital = JSON.parse(post[name]);
            }
        }
    } catch (error) {
        valueInital = {};
    }

    if (!valueInital) valueInital = {};

    post[name] = valueInital;

    const [value, setValue] = React.useState(valueInital.link);
    const [valueInput, setValueInput] = React.useState(valueInital.link);
    const [render, setRender] = React.useState(0);
    const [openLoadingCustom, setOpenLoadingCustom] = React.useState(false);

    const handleClickOpenSourceDialog = () => {
        setValueInput(valueInital.link);
        setOpenSourDialog(true);
    };

    const handleCloseSourceDialog = () => {
        setOpenSourDialog(false);
    };

    const handleOkSourceDialog = () => {
        setValue({ link: valueInput });
        setOpenSourDialog(false);
    }


    const handleClickOpenFilemanagerDialog = () => {
        setLoadingFileManage(true);
        setOpenFilemanagerDialog(true);
    };

    const handleCloseFilemanagerDialog = () => {
        setOpenFilemanagerDialog(false);
    };

    const handleClickRemoveImage = () => {
        validateImage(null, (result) => {
            post[name] = result;
            onReview(result);
            setRender(render + 1);
        });
    };

    const validateImage = (linkImage, callback) => {

        if (linkImage && linkImage.link) {

            setOpenLoadingCustom(true);

            let img = new Image();

            let link = linkImage.link;
            let type_link = 'local';

            if (validURL(link)) {
                if (!(link.search(process.env.REACT_APP_BASE_URL) > -1)) {
                    type_link = 'external';
                } else {
                    link = link.replace(process.env.REACT_APP_BASE_URL, '');
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
                            options: { preventDuplicate: false, variant: 'error', anchorOrigin: { vertical: 'top', horizontal: 'center' } }
                        },
                            { preventDuplicate: false, variant: 'error', anchorOrigin: { vertical: 'top', horizontal: 'center' } }
                        );
                        setOpenLoadingCustom(false);
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
            img.src = decodeURIComponent(link);

        } else {
            callback({});
        }
    }

    const [id, setID] = React.useState(makeid(10, 'field'));

    React.useEffect(() => {
        window.addEventListener('message', eventListenerMessage);
        return () => {
            delete window.ids[id];
            window.removeEventListener('message', eventListenerMessage);
        };
    }, []);

    const eventListenerMessage = (event) => {
        let data = event.data;
        switch (data.type) {
            case 'RELOAD_PAGE':
                setLoadingFileManage(true);
                break;
            case 'VALIDATE_IMAGE':
                if (data.id === id) {
                    validateImage({ link: data.value }, (result) => {
                        if (result.link) {
                            post[name] = result;
                            onReview(result);
                            setOpenSourDialog(false);
                            setOpenFilemanagerDialog(false);
                        }
                    });
                }
                break;
            case 'REQUIRED_LOGIN':

                if (data.id === id) {
                    dispatch(updateRequireLogin({
                        open: true, updateUser: false, callback: () => {
                            setLoadingFileManage(true);
                            document.getElementById(id).src = process.env.REACT_APP_FILEMANAGE_URL + '?id=' + id + '&type=1&field_id=image_link&multi=0&access_token=' + localStorage.getItem('access_token');
                        }
                    }));
                }

                break;
            default:
                break;
        }

    };

    React.useEffect(() => {

        if (render > 0) {
            validateImage(value, (data) => {
                post[name] = data;
                onReview(data);
                setRender(render + 1);
            });
        }

    }, [value]);

    console.log('render IMAGE');
    return (

        <FormControl fullWidth component="fieldset">
            <FormLabel style={{ marginBottom: 5 }} component="legend">{config.title}</FormLabel>
            <FormGroup style={{ marginBottom: 5 }}>
                <div>
                    <Button
                        key='left'
                        variant="contained"
                        color="default"
                        startIcon={<ImageOutlined />}
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
                            value={unescape(valueInput ? valueInput.replaceAll(process.env.REACT_APP_BASE_URL, '') : '')}
                            onChange={e => setValueInput(e.target.value)}
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
                            title={
                                <Toolbar>
                                    <IconButton edge="start" color="inherit" onClick={handleCloseFilemanagerDialog} aria-label="close">
                                        <CloseIcon />
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
                            {loadingFileManage && <CircularCustom bg="white" />}
                            <iframe id={id} onLoad={() => setLoadingFileManage(false)} style={{ height: '100%', width: '100%', border: 'none' }} title="Filemanage" src={process.env.REACT_APP_FILEMANAGE_URL + '?id=' + id + '&type=1&field_id=image_link&multi=0&access_token=' + localStorage.getItem('access_token')} />
                        </DrawerCustom>
                    </FormControl>
                </DialogCustom>
            </FormGroup>
            {post[name].link &&
                <div>
                    <div style={{ marginBottom: 5, position: 'relative', display: 'inline-block' }}>
                        <IconButton style={{ background: 'rgba(32,33,36,0.6)' }} onClick={handleClickRemoveImage} size="small" className={classes.removeImg} aria-label="Remove Image" component="span">
                            <HighlightOffOutlinedIcon style={{ color: 'rgba(255,255,255,0.851)' }} />
                        </IconButton>
                        <CardMedia
                            onClick={handleClickOpenSourceDialog}
                            style={{ maxWidth: '100%', maxHeight: 160, minWidth: 160, width: 'auto', cursor: 'pointer' }}
                            component="img"
                            image={post[name].type_link === 'local' ? process.env.REACT_APP_BASE_URL + post[name].link : post[name].link}
                        />
                    </div>
                </div>
            }
            {
                Boolean(config.size || config.thumbnail)
                &&
                <Alert icon={false} severity="info">
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
            }
            <FormHelperText>{config.note}</FormHelperText>
            <LoadingCustom open={openLoadingCustom} style={{ zIndex: 1301 }} />
        </FormControl>
    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})