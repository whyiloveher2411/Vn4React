import { Tooltip, withStyles } from '@material-ui/core';

const CustomTooltip = withStyles({
    tooltip: {
        color: "#000",
        backgroundColor: "white",
        margin: 5,
        minWidth: 250,
        maxWidth: 'unset',
        fontSize: 13,
        boxShadow: '0 4px 5px 0 rgb(0 0 0 / 14%), 0 1px 10px 0 rgb(0 0 0 / 12%), 0 2px 4px -1px rgb(0 0 0 / 20%)',
        fontWeight: 400,
        lineHeight: '22px',
        padding: 16,
        '& a': {
            color: 'rgba(0,0,0,0.54)',
            display: 'block',
            font: '500 14px / 20px Roboto,RobotoDraft,Helvetica,Arial,sans-serif',
            letterSpacing: '.5px',
            lineHeight: '16px',
            paddingTop: '8px',
            textTransform: 'uppercase'
        }
    }
})(Tooltip);


export default CustomTooltip;

