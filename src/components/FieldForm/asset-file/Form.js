import { AppBar, CardMedia, CircularProgress, Dialog, FormControl, FormGroup, FormHelperText, FormLabel, IconButton, InputAdornment, InputLabel, makeStyles, OutlinedInput } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import Slide from '@material-ui/core/Slide';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import CloseIcon from '@material-ui/icons/Close';
import FolderOpenOutlinedIcon from '@material-ui/icons/FolderOpenOutlined';
import HighlightOffOutlinedIcon from '@material-ui/icons/HighlightOffOutlined';
import InsertDriveFileOutlinedIcon from '@material-ui/icons/InsertDriveFileOutlined';
import { updateRequireLogin } from 'actions/requiredLogin';
import { DialogCustom, DrawerCustom } from 'components';
import React from 'react';
import { useDispatch } from 'react-redux';
import { makeid } from 'utils/helper';
import { validURL } from 'utils/herlperUrl';
import GoogleDrive from '../image/GoogleDrive';


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

    root: {
        position: 'absolute',
        height: '100%',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        width: '100%',
        background: 'white',
    },
    bottom: {
        color: theme.palette.grey[theme.palette.type === 'light' ? 200 : 700],
    },
    top: {
        color: '#1a90ff',
        animationDuration: '550ms',
        position: 'absolute',
    },
    circle: {
        strokeLinecap: 'round',
    },
    removeImg: {
        position: 'absolute',
        top: 3,
        right: 3
    }
}));

function FacebookCircularProgress(props) {
    const classes = useStyles();

    return (
        <div className={classes.root}>
            <CircularProgress
                variant="determinate"
                className={classes.bottom}
                size={40}
                thickness={4}
                {...props}
                value={100}
            />
            <CircularProgress
                variant="indeterminate"
                disableShrink
                className={classes.top}
                classes={{
                    circle: classes.circle,
                }}
                size={40}
                thickness={4}
                {...props}
            />
        </div>
    );
}


export default React.memo(function ImageForm(props) {

    const { config, post, name, onReview } = props;

    const classes = useStyles();

    const [openSourDialog, setOpenSourDialog] = React.useState(false);
    const [openFilemanagerDialog, setOpenFilemanagerDialog] = React.useState(false);

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

    const handleClickOpenSourceDialog = () => {
        setValueInput(valueInital.link);
        setOpenSourDialog(true);
    };

    const handleCloseSourceDialog = () => {
        setOpenSourDialog(false);
    };

    const handleOkSourceDialog = () => {
        setValue(valueInput);
        setOpenSourDialog(false);
    }

    const handleClickOpenFilemanagerDialog = () => {
        setOpenFilemanagerDialog(true);
    };

    const handleCloseFilemanagerDialog = () => {
        setOpenFilemanagerDialog(false);
    };

    const handleClickRemoveImage = () => {
        setValue('');
    };

    React.useEffect(() => {
        if (value) {

            let type_link = 'local';
            let link = value;

            if (validURL(link)) {

                if (!(value.search(process.env.REACT_APP_BASE_URL) > -1)) {
                    type_link = 'external';
                } else {
                    link = link.replace(process.env.REACT_APP_BASE_URL, '');
                }
            }

            let v = {
                link: link,
                type_link: type_link,
                ext: value.split('.').pop(),
            };
            post[name] = v;
            onReview(v);
            setRender(render + 1);
        } else {
            post[name] = {};
            onReview({});
            setRender(render + 1);
        }
    }, [value]);

    const filesActive = React.useState({});

    const handleChooseFile = (file) => {
        setValueInput(file.public_path);
        setOpenFilemanagerDialog(false);
    };

    console.log('render ASSET FILE');

    return (

        <FormControl required component="fieldset">
            <FormLabel style={{ marginBottom: 5 }} component="legend">{config.title}</FormLabel>

            {post[name].link &&
                <div>
                    <div style={{ marginBottom: 5, position: 'relative', display: 'inline-block' }}>
                        <IconButton style={{ background: 'rgba(32,33,36,0.6)' }} onClick={handleClickRemoveImage} size="small" className={classes.removeImg} aria-label="Remove Image" component="span">
                            <HighlightOffOutlinedIcon style={{ color: 'rgba(255,255,255,0.851)' }} />
                        </IconButton>
                        <CardMedia
                            onClick={handleClickOpenSourceDialog}
                            style={{ maxWidth: '100%', width: 'auto', cursor: 'pointer' }}
                            component="img"
                            image={'/admin/fileExtension/ico/' + (post[name].ext.replace(/[^a-zA-Z0-9]/g, "").toLowerCase() + '.jpg')}
                        />
                    </div>
                    <Typography variant="body2" style={{ marginBottom: 16, wordBreak: 'break-all' }}>
                        {unescape(post[name].link.replace(/^.*[\\/]/, ''))}
                    </Typography>
                </div>
            }
            <FormGroup>
                <div>
                    <Button
                        key='left'
                        variant="contained"
                        color="default"
                        startIcon={<InsertDriveFileOutlinedIcon />}
                        onClick={handleClickOpenSourceDialog}
                    >
                        Choose File


                    </Button>
                </div>

                <DialogCustom
                    open={openSourDialog}
                    onClose={handleCloseSourceDialog}
                    title="Insert/edit File"
                    action={
                        <>
                            <Button onClick={handleCloseSourceDialog}>
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
                            value={unescape(valueInput ? valueInput.replace(process.env.REACT_APP_BASE_URL, '') : '')}
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
                            disableEscapeKeyDown
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
                            <GoogleDrive filesActive={filesActive} fileType={['ext_file', 'ext_image', 'ext_misc', 'ext_video', 'ext_music']} handleChooseFile={handleChooseFile} config={config} />
                        </DrawerCustom>
                    </FormControl>
                </DialogCustom>
            </FormGroup>
            <FormHelperText>{config.note}</FormHelperText>
        </FormControl>
    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})
