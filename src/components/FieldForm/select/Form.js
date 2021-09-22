import { FormControl, FormHelperText, makeStyles, TextField, Typography } from '@material-ui/core';
import { Alert, Autocomplete } from '@material-ui/lab';
import React from 'react';


const useStyles = makeStyles(() => ({
    select: {
        '& .MuiSelect-selectMenu': {
            whiteSpace: 'unset'
        }
    },
    selectItem: {
        whiteSpace: 'unset'
    },
    menu: {
        '& .MuiPaper-root': {
            width: 200
        }
    },
    helperText: {
        marginBottom: 8
    }
}))

export default React.memo(function SelectForm(props) {

    const { config, post, onReview, name, ...rest } = props;

    const [render, setRender] = React.useState(0);

    const [listOption, setListOption] = React.useState(
        config.list_option ?
            Object.keys(config.list_option).map((key) => ({ ...config.list_option[key], _key: key }))
            :
            []
    );

    const classes = useStyles();

    let valueInital = null;

    if (post && post[name] && config.list_option && config.list_option[post[name]]) {
        valueInital = { ...config.list_option[post[name]], _key: post[name] };
    } else if (config.defaultValue) {
        valueInital = { ...config.list_option[config.defaultValue], _key: config.defaultValue };
    } else {
        valueInital = { _key: '__', title: '' };
    }


    const onChange = (e, value) => {
        if (value) {
            post[name] = value._key;
        } else {
            post[name] = config.defaultValue ? config.defaultValue : '';
        }

        onReview(post[name], name);
        setRender(prev => prev + 1);
    }

    return (
        <FormControl fullWidth variant="outlined">
            <Autocomplete
                options={listOption}
                getOptionLabel={(option) => option.title ? option.title : ''}
                disableClearable={config.disableClearable ? Boolean(config.disableClearable) : false}
                size={config.size ?? 'medium'}
                renderInput={(params) => {
                    return <>
                        <TextField {...params} label={config.title} variant="outlined" />
                        {
                            Boolean(config.note) &&
                            <FormHelperText ><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
                        }
                        {
                            Boolean(valueInital && valueInital.description && !config.disableAlert) &&
                            <Alert icon={false} severity="info">
                                <Typography variant="body2">{valueInital.description}</Typography>
                            </Alert>
                        }
                    </>
                }}
                onChange={onChange}
                value={valueInital}
                getOptionSelected={(option, value) => option._key === value._key}
                renderOption={(option) => (
                    <div className={classes.selectItem}>
                        {option.title}
                        {
                            Boolean(option.description) &&
                            <Typography variant="body2">{option.description}</Typography>
                        }
                    </div>
                )}
                {...config.inputProps}
            />
        </FormControl>

    );
    // return (
    //     <FormControl className={classes.select} fullWidth variant="outlined">
    //         <InputLabel>{config.title}</InputLabel>
    //         <Select
    //             label={config.title}
    //             value={valueInital}
    //             {...rest}
    //             onChange={(e) => { setValue(value + 1); onReview(e.target.value) }}
    //             MenuProps={{
    //                 className: classes.menu
    //             }}
    //         >
    //             {
    //                 Boolean(config.displayEmpty) &&
    //                 <MenuItem value="">
    //                     <em>--select--</em>
    //                 </MenuItem>
    //             }
    //             {
    //                 Object.keys(config.list_option).map((key, index) =>
    //                     <MenuItem key={key} value={key} className={classes.selectItem}>
    //                         <div>
    //                             {index + 1}. {config.list_option[key].title}
    //                             {
    //                                 Boolean(config.list_option[key].description) &&
    //                                 <Typography variant="body2">{config.list_option[key].description}</Typography>
    //                             }
    //                         </div>
    //                     </MenuItem>
    //                 )
    //             }

    //         </Select>
    //         <FormHelperText>{config.note}</FormHelperText>
    //     </FormControl >

    // )
}, (props1, props2) => {
    return JSON.stringify(props1) === JSON.stringify(props2);
})

