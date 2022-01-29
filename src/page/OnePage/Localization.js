import React from 'react'
import { usePermission } from 'utils/user';
import RedirectWithMessage from 'components/RedirectWithMessage';
import PageHeaderSticky from 'components/Page/PageHeaderSticky';
import { __, getLanguages, getLanguage } from 'utils/i18n';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TablePagination from '@material-ui/core/TablePagination';
import TableRow from '@material-ui/core/TableRow';
import NotFound from 'components/NotFound';
import { useAjax } from 'utils/useAjax';
import { fade } from '@material-ui/core/styles/colorManipulator';
import FieldForm from 'components/FieldForm';
import { Box, Checkbox, FormControlLabel, IconButton, InputAdornment, Paper, TextField, withStyles } from '@material-ui/core';
import MaterialIcon from 'components/MaterialIcon';
import { addClasses } from 'utils/dom';
import useDraggableScroll from 'utils/useDraggableScroll';
import { Alert } from '@material-ui/lab';
import Button from 'components/Button';
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom';

const StickyTableCell = withStyles((theme) => ({
    head: {
        left: 0,
        position: "sticky",
        zIndex: 3,
    },
    body: {
        backgroundColor: theme.palette.background.paper,
        minWidth: "50px",
        left: 0,
        position: "sticky",
        zIndex: 1,
        borderRight: '1px solid ' + theme.palette.divider,
    }
}))(TableCell);

const useStyles = makeStyles((theme) => ({
    container: {
        maxHeight: 650,
    },
    tdCell: {
        width: 400,
    },
    editCell: {
        borderLeft: '1px solid transparent',
        borderRight: '1px solid transparent',
        borderTop: '1px solid transparent',
        padding: 8,
        cursor: 'pointer',
        position: 'relative',
        '&:hover': {
            border: '1px solid ' + fade(theme.palette.text.primary, 0.3)
        },
        '& .MuiInputBase-root': {
            padding: '6px 0 6px 14px',
        },
        '&:hover $editButton': {
            display: 'block',
        },
    },
    hasChange: {
        backgroundColor: fade(theme.palette.success.main, 0.12)
    },
    boxLoading: {
        zIndex: 1,
        backgroundColor: fade(theme.palette.text.primary, 0.1)
    },
    noContentTrans: {
        borderColor: fade(theme.palette.secondary.main, 0.3)
    },
    editButton: {
        display: 'none',
        position: 'absolute',
        right: 0,
        top: 'calc(50% - 15px)'
    },
    textPlainValue: {
        paddingRight: 20,
    }
}));

const languages = getLanguages();
const languageCurrent = getLanguage();

function Localization() {

    const permission = usePermission('localization_management').localization_management;

    const match = useRouteMatch();
    const history = useHistory();
    const { tab } = match.params;

    const classes = useStyles();
    const [page, setPage] = React.useState(0);
    const [rowsPerPage, setRowsPerPage] = React.useState(10);

    const [listLanguageWithTrans, setListLanguageWithTrans] = React.useState(false);
    const [untranslated, setUntranslated] = React.useState(false);
    const [percentCompleted, setPercentCompleted] = React.useState({});
    const [keysChange, setKeysChange] = React.useState({});
    const [group, setGroup] = React.useState(false);
    const [keys, setKeys] = React.useState([]);

    const refScroll = React.useRef(null);
    const { onMouseDown } = useDraggableScroll(refScroll)

    const useApi = useAjax({ loadingType: 'custom' });

    const handleChangePage = (event, newPage) => {
        setPage(newPage);
    };

    const handleChangeRowsPerPage = (event) => {
        setRowsPerPage(+event.target.value);
        setPage(0);
    };

    const addRows = (trans) => {

        if (trans && typeof trans === 'object' && !Array.isArray(trans)) {

            let keysTrans = Object.keys(trans[languageCurrent.code]), result = {}, percentCompleted = {};

            languages.forEach(lang => {

                let countTranslated = 0;

                let dataForLang = {};

                keysTrans.forEach(key => {
                    dataForLang[key] = {
                        isEdit: false,
                        valueAfterEdit: trans[lang.code][key],
                        value: trans[lang.code][key],
                        valueOld: trans[lang.code][key],
                    };

                    if (trans[lang.code][key]) {
                        countTranslated++;
                    }
                });

                percentCompleted[lang.code] = countTranslated + ' - ' + Number(countTranslated * 100 / keysTrans.length).toFixed(1) + '%';
                result[lang.code] = dataForLang;
            });
            setPercentCompleted(() => percentCompleted);
            setListLanguageWithTrans(result);
            setKeysChange({});
            setKeys(keysTrans);
        } else {
            setPercentCompleted({});
            setListLanguageWithTrans(false);
        }
    }

    const handleClickEditTrans = (langCode, key) => (e) => {
        e.stopPropagation();

        setListLanguageWithTrans((prev) => {
            prev[langCode][key].isEdit = true;
            return { ...prev };
        });
    }

    const handleClickCancelEditTrans = (langCode, key) => (e) => {
        e.stopPropagation();

        setListLanguageWithTrans((prev) => {
            prev[langCode][key].isEdit = false;
            prev[langCode][key].valueAfterEdit = prev[langCode][key].value;
            return { ...prev };
        });
    }

    const handleClickSaveEditTrans = (langCode, key) => (e) => {
        e.stopPropagation();
        setListLanguageWithTrans((prev) => {
            prev[langCode][key].isEdit = false;
            prev[langCode][key].value = prev[langCode][key].valueAfterEdit;

            setKeysChangeAfterSave(prev);

            return { ...prev };
        });
    }

    const handleChangeTrans = (langCode, key) => (value) => {
        setListLanguageWithTrans((prev) => {
            prev[langCode][key].valueAfterEdit = value;
            return { ...prev };
        });
    }

    const checkTransHasBeenChanged = (langCode, key) => {
        return listLanguageWithTrans[langCode][key].value !== listLanguageWithTrans[langCode][key].valueOld
            && !(listLanguageWithTrans[langCode][key].value === '' && !listLanguageWithTrans[langCode][key].valueOld);
    }

    const setKeysChangeAfterSave = (trans) => {
        let result = {};
        languages.forEach(lang => {

            keys.forEach(key => {
                if (trans[lang.code][key].value && trans[lang.code][key].valueOld !== trans[lang.code][key].value) {
                    if (!result[key]) {
                        result[key] = {};
                    }
                    result[key][lang.code] = trans[lang.code][key].value;
                }
            });

        });
        setKeysChange(result);
    }

    const handleSubmitTrans = () => {

        useApi.ajax({
            url: 'localization/save-changes',
            data: {
                data: keysChange,
                languages: languages,
                group: tab,
            },
            success: (result) => {
                if (result.trans) {
                    addRows(result.trans);
                    setKeysChange({});
                }
            }
        });

    }

    React.useEffect(() => {

        setKeys([]);
        setKeysChange({});
        setPage(0);

        if (permission && tab) {
            useApi.ajax({
                url: 'localization/get-trans-text',
                data: {
                    group: tab
                },
                success: (result) => {
                    if (result.trans) {
                        addRows(result.trans);
                    }

                    if (result.group) {
                        setGroup(result.group);
                    }
                }
            });
        }
    }, [tab]);

    if (!tab) {
        return <Redirect to={'/localization/core'} />;
    }

    if (group && group.options && !group.options[tab]) {
        return <Redirect to={'/localization/' + Object.keys(group.options)[0]} />;
    }

    if (!permission) {
        return <RedirectWithMessage />
    }

    let dataAfterFilterPage = keys.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage);

    if (untranslated !== false) {
        dataAfterFilterPage = keys.filter(item => !listLanguageWithTrans[untranslated][item].valueOld).slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage);
    }

    return (
        <PageHeaderSticky
            title={__('Localization')}
            header={
                <Box display="flex" justifyContent="space-between" alignItems="center">
                    <div>
                        <Typography component="h2" gutterBottom variant="overline">{__('Settings')}</Typography>
                        <Typography component="h1" variant="h3">
                            {__('Localization')}
                        </Typography>
                    </div>
                    <Button
                        color="success"
                        variant="contained"
                        disabled={Object.keys(keysChange).length === 0}
                        onClick={handleSubmitTrans}
                    >
                        {__('Save Changes')}
                    </Button>
                </Box>
            }
        >
            <FieldForm
                compoment="select"
                config={{
                    title: __('Group'),
                    list_option: group?.options ?? {},
                    disableClearable: true,
                }}
                style={{ marginBottom: 16 }}
                post={{ group: group?.selected }}
                groupBy={(option) => option.group}
                name="group"
                onReview={(value) => history.push('/localization/' + value)}

            />
            <div style={{ position: 'relative' }}>
                <TableContainer component={Paper} className={classes.container + ' custom_scroll'} ref={refScroll} onMouseDown={onMouseDown}>
                    <Table stickyHeader aria-label="sticky table">
                        <TableHead>
                            <TableRow>
                                <StickyTableCell>
                                    <div className={classes.tdCell}>
                                        {__('Key')}
                                    </div>
                                </StickyTableCell>
                                {
                                    keys.length > 0 &&
                                    languages.map(lang => (
                                        <TableCell key={lang.code}>
                                            <Box className={classes.tdCell} display='flex' alignItems="center" justifyContent="space-between" gridGap={12}>
                                                <Box display='flex' alignItems="center" gridGap={12}>
                                                    <img
                                                        loading="lazy"
                                                        width="20"
                                                        src={`https://flagcdn.com/w20/${lang.flag.toLowerCase()}.png`}
                                                        srcSet={`https://flagcdn.com/w40/${lang.flag.toLowerCase()}.png 2x`}
                                                        alt=""
                                                    />
                                                    {lang.label} ({percentCompleted[lang.code]})
                                                </Box>
                                                <FormControlLabel
                                                    control={<Checkbox
                                                        onClick={() => {
                                                            if (untranslated === lang.code) {
                                                                setUntranslated(false);
                                                            } else {
                                                                setUntranslated(lang.code);
                                                            }
                                                        }}
                                                        name={lang.code}
                                                        checked={untranslated === lang.code}
                                                        color="primary"
                                                    />}
                                                    labelPlacement="start"
                                                    label={__('Un-translated')}
                                                />
                                            </Box>
                                        </TableCell>
                                    ))
                                }
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {
                                dataAfterFilterPage.length > 0 ?
                                    dataAfterFilterPage.map((key, index) => {
                                        return (
                                            <TableRow tabIndex={-1} key={index}>
                                                <StickyTableCell>
                                                    <div className={classes.tdCell}>
                                                        {key}
                                                    </div>
                                                </StickyTableCell>
                                                {
                                                    languages.map(lang => (
                                                        <TableCell key={lang.code} className={addClasses({
                                                            [classes.editCell]: true,
                                                            [classes.hasChange]:
                                                                listLanguageWithTrans[lang.code]
                                                                && checkTransHasBeenChanged(lang.code, key)
                                                                && !listLanguageWithTrans[lang.code][key].isEdit,
                                                            [classes.noContentTrans]: !listLanguageWithTrans[lang.code][key].value
                                                        })} >

                                                            <div className={classes.tdCell}>
                                                                {
                                                                    listLanguageWithTrans[lang.code][key].isEdit ?
                                                                        <FieldForm
                                                                            compoment="textarea"
                                                                            config={{
                                                                                title: '',
                                                                                size: 'small',
                                                                            }}
                                                                            endAdornment={
                                                                                <InputAdornment position="end">
                                                                                    <IconButton
                                                                                        aria-label="save"
                                                                                        color="primary"
                                                                                        onClick={handleClickSaveEditTrans(lang.code, key)}
                                                                                    >
                                                                                        <MaterialIcon icon="SaveOutlined" />
                                                                                    </IconButton>
                                                                                    <IconButton
                                                                                        aria-label="cancel"
                                                                                        onClick={handleClickCancelEditTrans(lang.code, key)}
                                                                                    >
                                                                                        <MaterialIcon icon="ClearRounded" />
                                                                                    </IconButton>
                                                                                </InputAdornment>
                                                                            }
                                                                            post={{ key: listLanguageWithTrans[lang.code][key].valueAfterEdit }}
                                                                            name="key"
                                                                            onReview={handleChangeTrans(lang.code, key)}
                                                                        />
                                                                        :
                                                                        <div className={classes.textPlainValue}>
                                                                            {listLanguageWithTrans[lang.code][key].value}
                                                                            <IconButton
                                                                                aria-label="cancel"
                                                                                className={classes.editButton}
                                                                                onClick={handleClickEditTrans(lang.code, key)}
                                                                                size='small'
                                                                            >
                                                                                <MaterialIcon icon="EditOutlined" />
                                                                            </IconButton>
                                                                        </div>
                                                                }
                                                            </div>
                                                        </TableCell>
                                                    ))}
                                            </TableRow>
                                        );
                                    })
                                    :
                                    <TableRow>
                                        <TableCell colSpan={100} style={{ height: 450 }}>
                                            <div
                                                style={{
                                                    position: 'absolute',
                                                    left: '50%',
                                                    transform: 'translateX(-50%)',
                                                    top: 80,
                                                    pointerEvents: 'none'
                                                }}>
                                                <NotFound
                                                    subTitle=""
                                                />
                                            </div>
                                        </TableCell>
                                    </TableRow>
                            }
                        </TableBody>
                    </Table>
                </TableContainer>
                <TablePagination
                    rowsPerPageOptions={[10, 25, 100, 200, 500]}
                    component="div"
                    count={keys.length}
                    rowsPerPage={rowsPerPage}
                    page={page}
                    onChangePage={handleChangePage}
                    onChangeRowsPerPage={handleChangeRowsPerPage}
                    labelRowsPerPage={__('Rows per page:')}
                    labelDisplayedRows={({ from, to, count }) => `${from} - ${to} ${__('of')} ${count !== -1 ? count : `${__('more than')} ${to}`}`}
                />
                {
                    useApi.open &&
                    <Box className={classes.boxLoading} display="flex" justifyContent="center" alignItems="center" width={1} position="absolute" top={0} bottom={0}>
                        {useApi.Loading}
                    </Box>
                }
            </div>

        </PageHeaderSticky >
    )
}

export default Localization
