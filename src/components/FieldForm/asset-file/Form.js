import { makeStyles } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import CardMedia from '@material-ui/core/CardMedia';
import FormControl from '@material-ui/core/FormControl';
import FormGroup from '@material-ui/core/FormGroup';
import FormHelperText from '@material-ui/core/FormHelperText';
import FormLabel from '@material-ui/core/FormLabel';
import IconButton from '@material-ui/core/IconButton';
import InputAdornment from '@material-ui/core/InputAdornment';
import InputLabel from '@material-ui/core/InputLabel';
import OutlinedInput from '@material-ui/core/OutlinedInput';
import Slide from '@material-ui/core/Slide';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import CloseIcon from '@material-ui/icons/Close';
import FolderOpenOutlinedIcon from '@material-ui/icons/FolderOpenOutlined';
import HighlightOffOutlinedIcon from '@material-ui/icons/HighlightOffOutlined';
import InsertDriveFileOutlinedIcon from '@material-ui/icons/InsertDriveFileOutlined';
import { DialogCustom, DrawerCustom } from 'components';
import React from 'react';
import { validURL } from 'utils/herlperUrl';
import { __ } from 'utils/i18n';
import GoogleDrive from '../image/GoogleDrive';


const Transition = React.forwardRef(function Transition(props, ref) {
    return <Slide direction="up" ref={ref} {...props} />;
});


const useStyles = makeStyles((theme) => ({
    root: {
        position: 'absolute',
        height: '100%',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        width: '100%',
        background: 'white',
    },
    title: {
        marginLeft: theme.spacing(1),
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

    const [openSourDialog, setOpenSourDialog] = React.useState(false);
    const [openFilemanagerDialog, setOpenFilemanagerDialog] = React.useState(false);



    React.useEffect(() => {

        let valueInital = {};

        try {
            if (typeof post[name] === 'object' && post[name] !== null) {
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

        onReview(valueInital);
        setValue(valueInital.link);
        setValueInput(valueInital.link);
    }, []);

    const [value, setValue] = React.useState(null);
    const [valueInput, setValueInput] = React.useState(null);
    const [render, setRender] = React.useState(0);

    const handleClickOpenSourceDialog = () => {
        setValueInput(post[name].link);
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

    return (

        <FormControl component="fieldset">
            <FormLabel style={{ marginBottom: 4 }} component="legend">{config.title}</FormLabel>

            {Boolean(post[name].link) &&
                <div>
                    <div style={{ marginBottom: 5, position: 'relative', display: 'inline-block' }}>
                        <IconButton style={{ background: 'rgba(32,33,36,0.6)' }} onClick={handleClickRemoveImage} size="small" className={classes.removeImg} aria-label="Remove Image" component="span">
                            <HighlightOffOutlinedIcon style={{ color: 'rgba(255,255,255,0.851)' }} />
                        </IconButton>
                        {
                            Boolean(post[name].ext) &&
                            <CardMedia
                                onClick={handleClickOpenSourceDialog}
                                style={{ maxWidth: '100%', width: 'auto', cursor: 'pointer' }}
                                component="img"
                                image={typeof post[name].ext === 'string' ? '/admin/fileExtension/ico/' + (post[name].ext.replace(/[^a-zA-Z0-9]/g, "").toLowerCase() + '.jpg') : ''}
                            />
                        }
                    </div>
                    <Typography variant="body2" style={{ marginBottom: 16, wordBreak: 'break-all' }}>
                        {typeof post[name].link === 'string' ? decodeURI(post[name].link.replace(/^.*[\\/]/, '')) : ''}
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
                        {__('Choose File')}
                    </Button>
                </div>

                <DialogCustom
                    open={openSourDialog}
                    onClose={handleCloseSourceDialog}
                    title={__('Insert/edit File')}
                    action={
                        <>
                            <Button onClick={handleCloseSourceDialog}>
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
                            label={__('Source (URL)')}
                        />

                        <DrawerCustom
                            open={openFilemanagerDialog}
                            onClose={handleCloseFilemanagerDialog}
                            TransitionComponent={Transition}
                            disableEscapeKeyDown
                            title={__('File Mangage')}
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
