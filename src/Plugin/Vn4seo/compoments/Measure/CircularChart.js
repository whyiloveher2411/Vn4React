import React from 'react'
import { makeStyles } from '@material-ui/core';
import { scoreLabel } from '../../helper';


const useStyles = makeStyles((theme) => ({
    root: {
        "& .vn4seo-singleChart": { "justifyContent": "space-around" },
        "& .vn4seo-circularChart": { "display": "block", "margin": "10px auto", "maxHeight": "120px" },
        "& .vn4seo-circle": { "fill": "none", "strokeWidth": "2.8", "strokeLinecap": "round", "animation": "$progress 2s ease-out forwards" },
        "& .vn4seo-percentage": { "fontFamily": "sans-serif", "fontSize": "0.5em", "textAnchor": "middle" },
    },
    '@keyframes progress': {
        '0%': {
            strokeDasharray: '0 100'
        }
    },
}));

function CircularChart({ scrore, width }) {

    const classes = useStyles();

    return (
        <div className={classes.root} style={{ width: '100%', maxWidth: width ?? 120 }}>
            <div className='vn4seo-singleChart' style={{
                '--color': 'var(--color-' + scoreLabel(scrore) + ')'
            }}>
                <svg viewBox="0 0 36 36" className='vn4seo-circularChart'>
                    <path style={{ fill: 'var(--color)', opacity: 0.1, strokeWidth: 2.8, stroke: 'var(--color)' }}
                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                    />
                    <path className='vn4seo-circle' style={{ stroke: 'var(--color)' }}
                        strokeDasharray={(scrore * 100) + ', 100'}
                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                    />
                    <text x="18" y="20.35" className='vn4seo-percentage' style={{ fill: 'var(--color)' }}>{(scrore * 100).toFixed(0)}%</text>
                </svg>
            </div>
        </div >
    )
}

export default CircularChart
