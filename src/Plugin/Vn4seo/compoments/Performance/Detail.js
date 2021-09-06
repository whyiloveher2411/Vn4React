import React from 'react'
import { Divider, makeStyles, colors, Card, CardContent, Button, FormControlLabel, FormGroup, Checkbox, CardHeader, Tooltip } from '@material-ui/core'
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TablePagination from '@material-ui/core/TablePagination';
import TableRow from '@material-ui/core/TableRow';
import FileCopyOutlinedIcon from '@material-ui/icons/FileCopyOutlined';
import OpenInNewIcon from '@material-ui/icons/OpenInNew';
import { CircularCustom } from '../../../../components';



const countriesCode = JSON.parse("{\"AFG\":\"Afghanistan\",\"ALA\":\"Åland Islands\",\"ALB\":\"Albania\",\"DZA\":\"Algeria\",\"ASM\":\"American Samoa\",\"AND\":\"Andorra\",\"AGO\":\"Angola\",\"AIA\":\"Anguilla\",\"ATA\":\"Antarctica\",\"ATG\":\"Antigua and Barbuda\",\"ARG\":\"Argentina\",\"ARM\":\"Armenia\",\"ABW\":\"Aruba\",\"AUS\":\"Australia\",\"AUT\":\"Austria\",\"AZE\":\"Azerbaijan\",\"BHS\":\"Bahamas\",\"BHR\":\"Bahrain\",\"BGD\":\"Bangladesh\",\"BRB\":\"Barbados\",\"BLR\":\"Belarus\",\"BEL\":\"Belgium\",\"BLZ\":\"Belize\",\"BEN\":\"Benin\",\"BMU\":\"Bermuda\",\"BTN\":\"Bhutan\",\"BOL\":\"Bolivia, Plurinational State of\",\"BES\":\"Bonaire, Sint Eustatius and Saba\",\"BIH\":\"Bosnia and Herzegovina\",\"BWA\":\"Botswana\",\"BVT\":\"Bouvet Island\",\"BRA\":\"Brazil\",\"IOT\":\"British Indian Ocean Territory\",\"BRN\":\"Brunei Darussalam\",\"BGR\":\"Bulgaria\",\"BFA\":\"Burkina Faso\",\"BDI\":\"Burundi\",\"KHM\":\"Cambodia\",\"CMR\":\"Cameroon\",\"CAN\":\"Canada\",\"CPV\":\"Cape Verde\",\"CYM\":\"Cayman Islands\",\"CAF\":\"Central African Republic\",\"TCD\":\"Chad\",\"CHL\":\"Chile\",\"CHN\":\"China\",\"CXR\":\"Christmas Island\",\"CCK\":\"Cocos (Keeling) Islands\",\"COL\":\"Colombia\",\"COM\":\"Comoros\",\"COG\":\"Congo\",\"COD\":\"Congo, the Democratic Republic of the\",\"COK\":\"Cook Islands\",\"CRI\":\"Costa Rica\",\"CIV\":\"Côte d'Ivoire\",\"HRV\":\"Croatia\",\"CUB\":\"Cuba\",\"CUW\":\"Curaçao\",\"CYP\":\"Cyprus\",\"CZE\":\"Czech Republic\",\"DNK\":\"Denmark\",\"DJI\":\"Djibouti\",\"DMA\":\"Dominica\",\"DOM\":\"Dominican Republic\",\"ECU\":\"Ecuador\",\"EGY\":\"Egypt\",\"SLV\":\"El Salvador\",\"GNQ\":\"Equatorial Guinea\",\"ERI\":\"Eritrea\",\"EST\":\"Estonia\",\"ETH\":\"Ethiopia\",\"FLK\":\"Falkland Islands (Malvinas)\",\"FRO\":\"Faroe Islands\",\"FJI\":\"Fiji\",\"FIN\":\"Finland\",\"FRA\":\"France\",\"GUF\":\"French Guiana\",\"PYF\":\"French Polynesia\",\"ATF\":\"French Southern Territories\",\"GAB\":\"Gabon\",\"GMB\":\"Gambia\",\"GEO\":\"Georgia\",\"DEU\":\"Germany\",\"GHA\":\"Ghana\",\"GIB\":\"Gibraltar\",\"GRC\":\"Greece\",\"GRL\":\"Greenland\",\"GRD\":\"Grenada\",\"GLP\":\"Guadeloupe\",\"GUM\":\"Guam\",\"GTM\":\"Guatemala\",\"GGY\":\"Guernsey\",\"GIN\":\"Guinea\",\"GNB\":\"Guinea-Bissau\",\"GUY\":\"Guyana\",\"HTI\":\"Haiti\",\"HMD\":\"Heard Island and McDonald Islands\",\"VAT\":\"Holy See (Vatican City State)\",\"HND\":\"Honduras\",\"HKG\":\"Hong Kong\",\"HUN\":\"Hungary\",\"ISL\":\"Iceland\",\"IND\":\"India\",\"IDN\":\"Indonesia\",\"IRN\":\"Iran, Islamic Republic of\",\"IRQ\":\"Iraq\",\"IRL\":\"Ireland\",\"IMN\":\"Isle of Man\",\"ISR\":\"Israel\",\"ITA\":\"Italy\",\"JAM\":\"Jamaica\",\"JPN\":\"Japan\",\"JEY\":\"Jersey\",\"JOR\":\"Jordan\",\"KAZ\":\"Kazakhstan\",\"KEN\":\"Kenya\",\"KIR\":\"Kiribati\",\"PRK\":\"Korea, Democratic People's Republic of\",\"KOR\":\"Korea, Republic of\",\"KWT\":\"Kuwait\",\"KGZ\":\"Kyrgyzstan\",\"LAO\":\"Lao People's Democratic Republic\",\"LVA\":\"Latvia\",\"LBN\":\"Lebanon\",\"LSO\":\"Lesotho\",\"LBR\":\"Liberia\",\"LBY\":\"Libya\",\"LIE\":\"Liechtenstein\",\"LTU\":\"Lithuania\",\"LUX\":\"Luxembourg\",\"MAC\":\"Macao\",\"MKD\":\"Macedonia, the former Yugoslav Republic of\",\"MDG\":\"Madagascar\",\"MWI\":\"Malawi\",\"MYS\":\"Malaysia\",\"MDV\":\"Maldives\",\"MLI\":\"Mali\",\"MLT\":\"Malta\",\"MHL\":\"Marshall Islands\",\"MTQ\":\"Martinique\",\"MRT\":\"Mauritania\",\"MUS\":\"Mauritius\",\"MYT\":\"Mayotte\",\"MEX\":\"Mexico\",\"FSM\":\"Micronesia, Federated States of\",\"MDA\":\"Moldova, Republic of\",\"MCO\":\"Monaco\",\"MNG\":\"Mongolia\",\"MNE\":\"Montenegro\",\"MSR\":\"Montserrat\",\"MAR\":\"Morocco\",\"MOZ\":\"Mozambique\",\"MMR\":\"Myanmar\",\"NAM\":\"Namibia\",\"NRU\":\"Nauru\",\"NPL\":\"Nepal\",\"NLD\":\"Netherlands\",\"NCL\":\"New Caledonia\",\"NZL\":\"New Zealand\",\"NIC\":\"Nicaragua\",\"NER\":\"Niger\",\"NGA\":\"Nigeria\",\"NIU\":\"Niue\",\"NFK\":\"Norfolk Island\",\"MNP\":\"Northern Mariana Islands\",\"NOR\":\"Norway\",\"OMN\":\"Oman\",\"PAK\":\"Pakistan\",\"PLW\":\"Palau\",\"PSE\":\"Palestinian Territory, Occupied\",\"PAN\":\"Panama\",\"PNG\":\"Papua New Guinea\",\"PRY\":\"Paraguay\",\"PER\":\"Peru\",\"PHL\":\"Philippines\",\"PCN\":\"Pitcairn\",\"POL\":\"Poland\",\"PRT\":\"Portugal\",\"PRI\":\"Puerto Rico\",\"QAT\":\"Qatar\",\"REU\":\"Réunion\",\"ROU\":\"Romania\",\"RUS\":\"Russian Federation\",\"RWA\":\"Rwanda\",\"BLM\":\"Saint Barthélemy\",\"SHN\":\"Saint Helena, Ascension and Tristan da Cunha\",\"KNA\":\"Saint Kitts and Nevis\",\"LCA\":\"Saint Lucia\",\"MAF\":\"Saint Martin (French part)\",\"SPM\":\"Saint Pierre and Miquelon\",\"VCT\":\"Saint Vincent and the Grenadines\",\"WSM\":\"Samoa\",\"SMR\":\"San Marino\",\"STP\":\"Sao Tome and Principe\",\"SAU\":\"Saudi Arabia\",\"SEN\":\"Senegal\",\"SRB\":\"Serbia\",\"SYC\":\"Seychelles\",\"SLE\":\"Sierra Leone\",\"SGP\":\"Singapore\",\"SXM\":\"Sint Maarten (Dutch part)\",\"SVK\":\"Slovakia\",\"SVN\":\"Slovenia\",\"SLB\":\"Solomon Islands\",\"SOM\":\"Somalia\",\"ZAF\":\"South Africa\",\"SGS\":\"South Georgia and the South Sandwich Islands\",\"SSD\":\"South Sudan\",\"ESP\":\"Spain\",\"LKA\":\"Sri Lanka\",\"SDN\":\"Sudan\",\"SUR\":\"Suriname\",\"SJM\":\"Svalbard and Jan Mayen\",\"SWZ\":\"Swaziland\",\"SWE\":\"Sweden\",\"CHE\":\"Switzerland\",\"SYR\":\"Syrian Arab Republic\",\"TWN\":\"Taiwan, Province of China\",\"TJK\":\"Tajikistan\",\"TZA\":\"Tanzania, United Republic of\",\"THA\":\"Thailand\",\"TLS\":\"Timor-Leste\",\"TGO\":\"Togo\",\"TKL\":\"Tokelau\",\"TON\":\"Tonga\",\"TTO\":\"Trinidad and Tobago\",\"TUN\":\"Tunisia\",\"TUR\":\"Turkey\",\"TKM\":\"Turkmenistan\",\"TCA\":\"Turks and Caicos Islands\",\"TUV\":\"Tuvalu\",\"UGA\":\"Uganda\",\"UKR\":\"Ukraine\",\"ARE\":\"United Arab Emirates\",\"GBR\":\"United Kingdom\",\"USA\":\"United States\",\"UMI\":\"United States Minor Outlying Islands\",\"URY\":\"Uruguay\",\"UZB\":\"Uzbekistan\",\"VUT\":\"Vanuatu\",\"VEN\":\"Venezuela, Bolivarian Republic of\",\"VNM\":\"Viet Nam\",\"VGB\":\"Virgin Islands, British\",\"VIR\":\"Virgin Islands, U.S.\",\"WLF\":\"Wallis and Futuna\",\"ESH\":\"Western Sahara\",\"YEM\":\"Yemen\",\"ZMB\":\"Zambia\",\"ZWE\":\"Zimbabwe\"}");

const dimensions = [
    {
        id: 'query',
        title: 'Queries',
    },
    {
        id: 'page',
        title: 'Pages',
        func: (item) => {
            return <>
                {item.keys[0]}
                <span className="actionIcon" style={{ position: 'absolute', right: 0, cursor: 'pointer' }}>
                    <Tooltip title="Copy url to clipboard">
                        <FileCopyOutlinedIcon onClick={() => copyClipboard(item.keys[0])} style={{ color: '#263238', opacity: '.54', height: 18 }} />
                    </Tooltip>
                    <Tooltip title="Open a new tab">
                        <a target="_blank" href={item.keys[0]}><OpenInNewIcon style={{ color: '#263238', opacity: '.54', height: 18 }} /></a>
                    </Tooltip>
                </span>
            </>
        }
    },
    {
        id: 'country',
        title: 'Countries',
        func: (item) => {
            return <>{countriesCode[item.keys[0].toUpperCase()]}</>;
        }
    },
    {
        id: 'device',
        title: 'Devices',
    },
    {
        id: 'SEARCH_APPEARANCE',
        title: 'Search appearance'
    },
    {
        id: 'date',
        title: 'Dates'
    },

];


const copyClipboard = str => {
    const el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style.position = 'absolute';
    el.style.left = '-9999px';
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
};


const useStyles = makeStyles((theme) => ({
    tabsFilter: {
        position: 'relative',
        whiteSpace: 'nowrap',
        '&>.indicator': {
            backgroundColor: '#3f51b5',
            position: 'absolute',
            right: 0,
            height: 2,
            bottom: 0,
            transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
        },
    },
    tab: {
        borderRadius: 0, height: 64, padding: '0 16px', color: 'rgba(0,0,0,0.54)',
        '&.active': {
            fontWeight: 500,
            color: 'inherit',
        }
    },
    trRow: {
        wordBreak: 'break-all', position: 'relative', paddingRight: '58px',
        '& .actionIcon': {
            opacity: 0,
        },
        '&:hover .actionIcon': {
            opacity: 1,
        }
    },
    tdPoint: {
        backgroundColor: 'inherit', padding: '0 28px', width: 50,
        textAlign: 'center'
    }
}));

function Detail({ ajaxPluginHandle, website, date, labelDateFilter }) {

    const classes = useStyles();

    const [data, setData] = React.useState(false);
    const [tabCurrent, setTabCurrent] = React.useState(0);

    const [loading, setLoading] = React.useState(true);

    const activeTab = React.useRef(null);
    const indicatorRef = React.useRef(null);

    React.useEffect(() => {

        indicatorRef.current.style.left = activeTab.current.offsetLeft + 'px';
        indicatorRef.current.style.width = activeTab.current.offsetWidth + 'px';
        setLoading(true);
        callAPI();

    }, [tabCurrent, website, date]);

    const [page, setPage] = React.useState(0);
    const [rowsPerPage, setRowsPerPage] = React.useState(10);

    const handleChangePage = (event, newPage) => {
        setPage(newPage);
    };

    const handleChangeRowsPerPage = (event) => {
        setRowsPerPage(+event.target.value);
        setPage(0);
    };

    const callAPI = () => {


        ajaxPluginHandle({
            url: 'dashboard/reports',
            notShowLoading: true,
            data: {
                step: 'getDataDetail',
                dimensions: dimensions[tabCurrent].id,
                website: website,
                date: labelDateFilter[date.index].date(),
            },
            success: (result) => {
                if (result.rows) {
                    setPage(0);
                    setData(result.rows);
                }
            },
            finally: () => {
                setLoading(false);
            }
        });
    };

    return (
        <Card>
            <div style={{ overflow: 'auto' }}>
                <div className={classes.tabsFilter}>
                    {
                        dimensions.map((item, i) => (
                            <Button onClick={() => setTabCurrent(i)} key={item.id} ref={tabCurrent === i ? activeTab : null} size="large" className={classes.tab + ' ' + (tabCurrent === i ? 'active' : '')}>{item.title}</Button>
                        ))
                    }
                    <span className='indicator' ref={indicatorRef}></span>
                </div>
            </div>
            <Divider />
            <CardContent style={{ padding: 0 }}>
                <TableContainer className={classes.container}>
                    <Table style={{ width: '100%' }} aria-label="table">
                        <TableHead>
                            <TableRow>
                                <TableCell style={{ backgroundColor: 'inherit' }}>
                                    {dimensions[tabCurrent].title}
                                </TableCell>
                                <TableCell className={classes.tdPoint}>
                                    Clicks
                                        </TableCell>
                                <TableCell className={classes.tdPoint}>
                                    Impressions
                                        </TableCell>
                                <TableCell className={classes.tdPoint}>
                                    CTR
                                        </TableCell>
                                <TableCell className={classes.tdPoint}>
                                    Position
                                        </TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {
                                loading === true ?
                                    <TableRow>
                                        <TableCell colSpan={5} style={{ fontSize: 16, position: 'relative', height: 180 }}>
                                            < CircularCustom />
                                        </TableCell>
                                    </TableRow>
                                    :
                                    data.length ?
                                        (
                                            dimensions[tabCurrent].func ?
                                                data.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage).map((row, i) => {
                                                    return (
                                                        <TableRow hover role="checkbox" tabIndex={-1} key={i}>
                                                            <TableCell className={classes.trRow}>
                                                                {dimensions[tabCurrent].func(row)}
                                                            </TableCell>
                                                            <TableCell className={classes.tdPoint}>
                                                                {row.clicks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}
                                                            </TableCell>
                                                            <TableCell className={classes.tdPoint}>
                                                                {row.impressions.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}
                                                            </TableCell>
                                                            <TableCell className={classes.tdPoint}>
                                                                {((row.ctr * 100).toFixed(1) * 1).toString()}%
                                                                </TableCell>
                                                            <TableCell className={classes.tdPoint}>
                                                                {((row.position).toFixed(1) * 1).toString()}
                                                            </TableCell>
                                                        </TableRow>
                                                    );
                                                })
                                                :
                                                data.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage).map((row, i) => {
                                                    return (
                                                        <TableRow hover role="checkbox" tabIndex={-1} key={i}>
                                                            <TableCell style={{ wordBreak: 'break-all' }}>
                                                                {row.keys[0]}
                                                            </TableCell>
                                                            <TableCell className={classes.tdPoint}>
                                                                {row.clicks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}
                                                            </TableCell>
                                                            <TableCell className={classes.tdPoint}>
                                                                {row.impressions.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}
                                                            </TableCell>
                                                            <TableCell className={classes.tdPoint}>
                                                                {((row.ctr * 100).toFixed(1) * 1).toString()}%
                                                                </TableCell>
                                                            <TableCell className={classes.tdPoint}>
                                                                {((row.position).toFixed(1) * 1).toString()}
                                                            </TableCell>
                                                        </TableRow>
                                                    );
                                                })
                                        )
                                        :
                                        <TableRow>
                                            <TableCell colSpan={5} style={{ fontSize: 16, padding: '176px 0', textAlign: 'center' }}>
                                                No data available
                                                </TableCell>
                                        </TableRow>

                            }
                        </TableBody>
                    </Table>
                </TableContainer>
                {
                    data.length ?
                        <TablePagination
                            rowsPerPageOptions={[10, 25, 100]}
                            component="div"
                            count={data.length}
                            rowsPerPage={rowsPerPage}
                            page={page}
                            onChangePage={handleChangePage}
                            onChangeRowsPerPage={handleChangeRowsPerPage}
                        />
                        : <></>
                }
            </CardContent>
        </Card>
    )
}

export default Detail
