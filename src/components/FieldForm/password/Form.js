import { FormControl, FormHelperText, IconButton, InputAdornment, InputLabel, OutlinedInput } from '@material-ui/core';
import RefreshIcon from '@material-ui/icons/Refresh';
import Visibility from '@material-ui/icons/Visibility';
import VisibilityOff from '@material-ui/icons/VisibilityOff';
import React from 'react';

export default React.memo(function PasswordForm(props) {

    console.log('render PASSWORD');

    const { config, post, onReview, name, ...rest } = props;

    const [values, setValues] = React.useState({
        password: post['_' + name] ? post['_' + name] : '',
        showPassword: false,
    });

    const handleChange = (prop) => (event) => {
        setValues({ ...values, [prop]: event.target.value });
    };

    const handleClickShowPassword = () => {
        setValues({ ...values, showPassword: !values.showPassword });
    };

    const handleMouseDownPassword = (event) => {
        event.preventDefault();
    };

    const randomPassword = () => {
        let chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz!@#$%^&*()_+<>?~";
        let string_length = 24;
        let randomstring = '';
        for (let i = 0; i < string_length; i++) {
            let rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum, rnum + 1);
        }

        setValues({ ...values, password: randomstring });
        onReview(randomstring)
    };

    return (
        <FormControl fullWidth variant="outlined">
            <InputLabel htmlFor="outlined-adornment-password">{config.title}</InputLabel>
            <OutlinedInput
                id="outlined-adornment-password"
                type={values.showPassword ? 'text' : 'password'}
                value={values.password}
                onBlur={e => { onReview(e.target.value) }}
                onChange={handleChange('password')}
                endAdornment={
                    <InputAdornment position="end">
                        {
                            (typeof config.generator === 'undefined' || config.generator) ?
                                <IconButton
                                    aria-label="generator password"
                                    onClick={randomPassword}
                                    edge="end"
                                >
                                    <RefreshIcon />
                                </IconButton>
                                : null
                        }
                        <IconButton
                            aria-label="toggle password visibility"
                            onClick={handleClickShowPassword}
                            onMouseDown={handleMouseDownPassword}
                            edge="end"
                        >
                            {values.showPassword ? <Visibility /> : <VisibilityOff />}
                        </IconButton>
                    </InputAdornment>
                }
                label={config.title}
                {...rest}
            />
            {
                Boolean(config.note) &&
                <FormHelperText ><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
            }
        </FormControl>



    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})
