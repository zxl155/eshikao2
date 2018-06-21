var cities = {
'110000': {name: '北京', 'cities': [['110000', '北京'], ]},
'120000': {name: '天津', 'cities': [['120000', '天津'], ]},
'130000': {name: '河北', 'cities': [['130100', '石家庄'], ['130200', '唐山'], ['130300', '秦皇岛'], ['130400', '邯郸'], ['130500', '邢台'], ['130600', '保定'], ['130700', '张家口'], ['130800', '承德'], ['130900', '沧州'], ['131000', '廊坊'], ['131100', '衡水'], ]},
'140000': {name: '山西', 'cities': [['140100', '太原'], ['140200', '大同'], ['140300', '阳泉'], ['140400', '长治'], ['140500', '晋城'], ['140600', '朔州'], ['140700', '晋中'], ['140800', '运城'], ['140900', '忻州'], ['141000', '临汾'], ['142300', '吕梁'], ]},
'150000': {name: '内蒙古', 'cities': [['150100', '呼和浩特'], ['150200', '包头'], ['150300', '乌海'], ['150400', '赤峰'], ['150500', '通辽'], ['150600', '鄂尔多斯'], ['150700', '呼伦贝尔'], ['152200', '兴安'], ['152500', '锡林郭勒'], ['152600', '乌兰察布'], ['152800', '巴彦淖尔'], ['152900', '阿拉善'], ]},
'210000': {name: '辽宁', 'cities': [['210100', '沈阳'], ['210200', '大连'], ['210300', '鞍山'], ['210400', '抚顺'], ['210500', '本溪'], ['210600', '丹东'], ['210700', '锦州'], ['210800', '营口'], ['210900', '阜新'], ['211000', '辽阳'], ['211100', '盘锦'], ['211200', '铁岭'], ['211300', '朝阳'], ['211400', '葫芦岛'], ]},
'220000': {name: '吉林', 'cities': [['220100', '长春'], ['220200', '吉林'], ['220300', '四平'], ['220400', '辽源'], ['220500', '通化'], ['220600', '白山'], ['220700', '松原'], ['220800', '白城'], ['222400', '延边'], ]},
'230000': {name: '黑龙江', 'cities': [['230100', '哈尔滨'], ['230200', '齐齐哈尔'], ['230300', '鸡西'], ['230400', '鹤岗'], ['230500', '双鸭山'], ['230600', '大庆'], ['230700', '伊春'], ['230800', '佳木斯'], ['230900', '七台河'], ['231000', '牡丹江'], ['231100', '黑河'], ['231200', '绥化'], ['232700', '大兴安岭'], ]},
'310000': {name: '上海', 'cities': [['310000', '上海'], ]},
'320000': {name: '江苏', 'cities': [['320100', '南京'], ['320200', '无锡'], ['320300', '徐州'], ['320400', '常州'], ['320500', '苏州'], ['320600', '南通'], ['320700', '连云港'], ['320800', '淮安'], ['320900', '盐城'], ['321000', '扬州'], ['321100', '镇江'], ['321200', '泰州'], ['321300', '宿迁'], ]},
'330000': {name: '浙江', 'cities': [['330100', '杭州'], ['330200', '宁波'], ['330300', '温州'], ['330400', '嘉兴'], ['330500', '湖州'], ['330600', '绍兴'], ['330700', '金华'], ['330800', '衢州'], ['330900', '舟山'], ['331000', '台州'], ['331100', '丽水'], ]},
'340000': {name: '安徽', 'cities': [['340100', '合肥'], ['340200', '芜湖'], ['340300', '蚌埠'], ['340400', '淮南'], ['340500', '马鞍山'], ['340600', '淮北'], ['340700', '铜陵'], ['340800', '安庆'], ['341000', '黄山'], ['341100', '滁州'], ['341200', '阜阳'], ['341300', '宿州'], ['341400', '巢湖'], ['341500', '六安'], ['341600', '亳州'], ['341700', '池州'], ['341800', '宣城'], ]},
'350000': {name: '福建', 'cities': [['350100', '福州'], ['350200', '厦门'], ['350300', '莆田'], ['350400', '三明'], ['350500', '泉州'], ['350600', '漳州'], ['350700', '南平'], ['350800', '龙岩'], ['350900', '宁德'], ]},
'360000': {name: '江西', 'cities': [['360100', '南昌'], ['360200', '景德镇'], ['360300', '萍乡'], ['360400', '九江'], ['360500', '新余'], ['360600', '鹰潭'], ['360700', '赣州'], ['360800', '吉安'], ['360900', '宜春'], ['361000', '抚州'], ['361100', '上饶'], ]},
'370000': {name: '山东', 'cities': [['370100', '济南'], ['370200', '青岛'], ['370300', '淄博'], ['370400', '枣庄'], ['370500', '东营'], ['370600', '烟台'], ['370700', '潍坊'], ['370800', '济宁'], ['370900', '泰安'], ['371000', '威海'], ['371100', '日照'], ['371200', '莱芜'], ['371300', '临沂'], ['371400', '德州'], ['371500', '聊城'], ['371600', '滨州'], ['371700', '菏泽'], ]},
'410000': {name: '河南', 'cities': [['410100', '郑州'], ['410200', '开封'], ['410300', '洛阳'], ['410400', '平顶山'], ['410500', '安阳'], ['410600', '鹤壁'], ['410700', '新乡'], ['410800', '焦作'], ['410881', '济源'], ['410900', '濮阳'], ['411000', '许昌'], ['411100', '漯河'], ['411200', '三门峡'], ['411300', '南阳'], ['411400', '商丘'], ['411500', '信阳'], ['411600', '周口'], ['411700', '驻马店'], ]},
'420000': {name: '湖北', 'cities': [['420100', '武汉'], ['420200', '黄石'], ['420300', '十堰'], ['420500', '宜昌'], ['420600', '襄樊'], ['420700', '鄂州'], ['420800', '荆门'], ['420900', '孝感'], ['421000', '荆州'], ['421100', '黄冈'], ['421200', '咸宁'], ['421300', '随州'], ['422800', '恩施'], ['429004', '仙桃'], ['429005', '潜江'], ['429006', '天门'], ['429021', '神农架'], ]},
'430000': {name: '湖南', 'cities': [['430100', '长沙'], ['430200', '株洲'], ['430300', '湘潭'], ['430400', '衡阳'], ['430500', '邵阳'], ['430600', '岳阳'], ['430700', '常德'], ['430800', '张家界'], ['430900', '益阳'], ['431000', '郴州'], ['431100', '永州'], ['431200', '怀化'], ['431300', '娄底'], ['433100', '湘西'], ]},
'440000': {name: '广东', 'cities': [['440100', '广州'], ['440200', '韶关'], ['440300', '深圳'], ['440400', '珠海'], ['440500', '汕头'], ['440600', '佛山'], ['440700', '江门'], ['440800', '湛江'], ['440900', '茂名'], ['441200', '肇庆'], ['441300', '惠州'], ['441400', '梅州'], ['441500', '汕尾'], ['441600', '河源'], ['441700', '阳江'], ['441800', '清远'], ['441900', '东莞'], ['442000', '中山'], ['445100', '潮州'], ['445200', '揭阳'], ['445300', '云浮'], ['440110', '从化'], ]},
'450000': {name: '广西', 'cities': [['450100', '南宁'], ['450200', '柳州'], ['450300', '桂林'], ['450400', '梧州'], ['450500', '北海'], ['450600', '防城港'], ['450700', '钦州'], ['450800', '贵港'], ['450900', '玉林'], ['451000', '百色'], ['451100', '贺州'], ['451200', '河池'], ['451300', '来宾'], ['451400', '崇左'], ]},
'460000': {name: '海南', 'cities': [['460100', '海口'], ['460200', '三亚'], ['469001', '五指山'], ['469002', '琼海'], ['469003', '儋州'], ['469005', '文昌'], ['469006', '万宁'], ['469007', '东方'], ['469025', '定安'], ['469026', '屯昌'], ['469027', '澄迈'], ['469028', '临高'], ['469030', '白沙'], ['469031', '昌江'], ['469033', '乐东'], ['469034', '陵水'], ['469035', '保亭'], ['469036', '琼中'], ['469037', '西沙'], ['469038', '南沙'], ['469039', '中沙'], ]},
'500000': {name: '重庆', 'cities': [['500000', '重庆'], ]},
'510000': {name: '四川', 'cities': [['510100', '成都'], ['510300', '自贡'], ['510400', '攀枝花'], ['510500', '泸州'], ['510600', '德阳'], ['510700', '绵阳'], ['510800', '广元'], ['510900', '遂宁'], ['511000', '内江'], ['511100', '乐山'], ['511300', '南充'], ['511400', '眉山'], ['511500', '宜宾'], ['511600', '广安'], ['511700', '达州'], ['511800', '雅安'], ['511900', '巴中'], ['512000', '资阳'], ['513200', '阿坝'], ['513300', '甘孜'], ['513400', '凉山'], ]},
'520000': {name: '贵州', 'cities': [['520100', '贵阳'], ['520200', '六盘水'], ['520300', '遵义'], ['520400', '安顺'], ['522200', '铜仁'], ['522300', '黔西南'], ['522400', '毕节'], ['522600', '黔东南'], ['522700', '黔南'], ]},
'530000': {name: '云南', 'cities': [['530100', '昆明'], ['530300', '曲靖'], ['530400', '玉溪'], ['530500', '保山'], ['530600', '昭通'], ['530700', '丽江'], ['532300', '楚雄'], ['532500', '红河'], ['532600', '文山'], ['532700', '思茅'], ['532800', '西双版纳'], ['532900', '大理'], ['533100', '德宏'], ['533300', '怒江'], ['533400', '迪庆'], ['533500', '临沧'], ]},
'540000': {name: '西藏', 'cities': [['540100', '拉萨'], ['542100', '昌都'], ['542200', '山南'], ['542300', '日喀则'], ['542400', '那曲'], ['542500', '阿里'], ['542600', '林芝'], ]},
'610000': {name: '陕西', 'cities': [['610100', '西安'], ['610200', '铜川'], ['610300', '宝鸡'], ['610400', '咸阳'], ['610500', '渭南'], ['610600', '延安'], ['610700', '汉中'], ['610800', '榆林'], ['610900', '安康'], ['611000', '商洛'], ]},
'620000': {name: '甘肃', 'cities': [['620100', '兰州'], ['620200', '嘉峪关'], ['620300', '金昌'], ['620400', '白银'], ['620500', '天水'], ['620600', '武威'], ['620700', '张掖'], ['620800', '平凉'], ['620900', '酒泉'], ['621000', '庆阳'], ['622400', '定西'], ['622600', '陇南'], ['622900', '临夏'], ['623000', '甘南'], ]},
'630000': {name: '青海', 'cities': [['630100', '西宁'], ['632100', '海东'], ['632200', '海北'], ['632300', '黄南'], ['632500', '海南'], ['632600', '果洛'], ['632700', '玉树'], ['632800', '海西'], ]},
'640000': {name: '宁夏', 'cities': [['640100', '银川'], ['640200', '石嘴山'], ['640300', '吴忠'], ['640400', '固原'], ]},
'650000': {name: '新疆', 'cities': [['650100', '乌鲁木齐'], ['650200', '克拉玛依'], ['652100', '吐鲁番'], ['652200', '哈密'], ['652300', '昌吉'], ['652700', '博尔塔拉'], ['652800', '巴音郭楞'], ['652900', '阿克苏'], ['653000', '克孜勒苏'], ['653100', '喀什'], ['653200', '和田'], ['654000', '伊犁'], ['654200', '塔城'], ['654300', '阿勒泰'], ['659001', '石河子'], ['659002', '阿拉尔'], ['659003', '图木舒克'], ['659004', '五家渠'], ]},
'710000': {name: '台湾', 'cities': [['710000', '台湾'], ]},
'810000': {name: '香港', 'cities': [['810000', '香港'], ]},
'910000': {name: '澳门', 'cities': [['910000', '澳门'], ]},
'990000': {name: '其他国家和地区', 'cities': [['990001', '阿富汗'], ['990002', '阿尔巴尼亚'], ['990003', '阿尔及利亚'], ['990004', '东萨摩亚(美)'], ['990005', '安道尔'], ['990006', '安哥拉'], ['990007', '安提瓜和巴布达岛'], ['990008', '阿塞拜疆'], ['990009', '阿根廷'], ['990010', '澳大利亚'], ['990011', '奥地利'], ['990012', '巴哈马'], ['990013', '巴林'], ['990014', '孟加拉国'], ['990015', '亚美尼亚'], ['990016', '巴巴多斯'], ['990017', '比利时'], ['990018', '百慕大'], ['990019', '不丹'], ['990020', '玻利维亚'], ['990021', '波黑地区'], ['990022', '博茨瓦那'], ['990023', '巴西'], ['990024', '伯利兹'], ['990025', '所罗门群岛'], ['990026', '英属维尔京群岛'], ['990027', '文莱'], ['990028', '保加利亚'], ['990029', '布隆迪'], ['990030', '白俄罗斯'], ['990031', '喀麦隆'], ['990032', '加拿大'], ['990033', '佛得角'], ['990034', '开曼群岛(新西兰)'], ['990035', '中非共和国'], ['990036', '斯里兰卡'], ['990037', '乍得'], ['990038', '智利'], ['990041', '哥伦比亚'], ['990042', '科摩罗'], ['990043', '刚果'], ['990044', '库克群岛'], ['990045', '哥斯达黎加'], ['990046', '克罗地亚'], ['990047', '古巴'], ['990048', '塞浦路斯'], ['990049', '捷克'], ['990050', '贝宁'], ['990051', '丹麦'], ['990052', '多米尼加'], ['990053', '多米尼加共和国'], ['990054', '厄瓜多尔'], ['990055', '萨尔瓦多'], ['990056', '赤道几内亚'], ['990057', '埃塞俄比亚'], ['990058', '厄立特里亚'], ['990059', '爱沙尼亚'], ['990060', '法罗群岛'], ['990061', '福克兰群岛'], ['990062', '斐济群岛'], ['990063', '芬兰'], ['990064', '法国'], ['990065', '法属圭亚那'], ['990066', '法属玻利尼西亚'], ['990067', '吉布提'], ['990068', '加蓬'], ['990069', '格鲁吉亚'], ['990070', '冈比亚'], ['990072', '德国'], ['990073', '加纳'], ['990074', '直布罗陀'], ['990075', '基里巴斯'], ['990076', '希腊'], ['990077', '格林兰'], ['990078', '格林纳达'], ['990079', '瓜德罗普'], ['990080', '关岛'], ['990081', '危地马拉'], ['990082', '几内亚'], ['990083', '圭亚那'], ['990084', '海地'], ['990085', '梵蒂冈'], ['990086', '洪都拉斯'], ['990088', '匈牙利'], ['990089', '冰岛'], ['990090', '印度'], ['990091', '印度尼西亚'], ['990092', '伊朗'], ['990093', '伊拉克'], ['990094', '爱尔兰'], ['990095', '以色列'], ['990096', '意大利'], ['990097', '牙买加'], ['990098', '日本'], ['990099', '哈萨克斯坦'], ['990100', '约旦'], ['990101', '肯尼亚'], ['990102', '朝鲜'], ['990103', '韩国'], ['990104', '科威特'], ['990105', '吉尔吉斯坦'], ['990106', '老挝'], ['990107', '黎巴嫩'], ['990108', '莱索托'], ['990109', '拉托维亚'], ['990110', '利比里亚'], ['990111', '利比亚'], ['990112', '列支敦士登'], ['990113', '立陶宛'], ['990114', '卢森堡'], ['990116', '马达加斯加'], ['990117', '马拉维'], ['990118', '马来西亚'], ['990119', '马尔代夫'], ['990120', '马里'], ['990121', '马耳他'], ['990122', '马提尼克'], ['990123', '毛里塔尼亚'], ['990124', '毛里求斯'], ['990125', '墨西哥'], ['990126', '摩纳哥'], ['990127', '蒙古'], ['990128', '摩尔多瓦'], ['990129', '蒙特塞拉特'], ['990130', '摩洛哥'], ['990131', '莫桑比克'], ['990132', '阿曼'], ['990133', '纳米比亚'], ['990134', '瑙鲁'], ['990135', '尼泊尔'], ['990136', '荷兰'], ['990137', '荷属安的列斯'], ['990138', '阿鲁巴'], ['990139', '新喀里多尼亚'], ['990140', '瓦努阿图'], ['990141', '新西兰'], ['990142', '尼加拉瓜'], ['990143', '尼日尔'], ['990144', '尼日利亚'], ['990145', '纽埃岛'], ['990146', '诺福克岛(澳)'], ['990147', '挪威'], ['990148', '北马里亚纳群岛'], ['990149', '密克罗尼西亚'], ['990150', '马绍尔群岛'], ['990151', '帕劳'], ['990152', '巴基斯坦'], ['990153', '巴拿马'], ['990154', '巴布亚新几内亚'], ['990155', '巴拉圭'], ['990156', '秘鲁'], ['990157', '菲律宾'], ['990158', '皮特凯恩群岛(英)'], ['990159', '波兰'], ['990160', '葡萄牙'], ['990161', '几内亚比绍'], ['990162', '东帝汶'], ['990163', '波多黎各'], ['990164', '卡塔尔'], ['990165', '留尼汪岛'], ['990166', '罗马尼亚'], ['990167', '俄罗斯'], ['990168', '卢旺达'], ['990169', '圣海伦娜'], ['990170', '圣吉斯和尼维斯'], ['990171', '安圭拉岛(英)'], ['990172', '圣卢西亚岛'], ['990173', '圣皮埃尔岛及密克隆岛'], ['990174', '圣文森特和格林纳丁斯'], ['990175', '圣马力诺'], ['990176', '圣多美和普林西比'], ['990177', '沙特阿拉伯王国'], ['990178', '塞内加尔'], ['990179', '塞舌尔'], ['990180', '塞拉利昂'], ['990181', '新加坡'], ['990182', '斯洛伐克'], ['990183', '越南'], ['990184', '斯洛文尼亚'], ['990185', '索马里'], ['990186', '南非'], ['990187', '津巴布韦'], ['990188', '西班牙'], ['990189', '西撒哈拉'], ['990190', '苏丹'], ['990191', '苏里南'], ['990192', '斯瓦尔巴岛和扬马延岛'], ['990193', '斯威士兰'], ['990194', '瑞典'], ['990195', '瑞士'], ['990196', '叙利亚'], ['990197', '塔吉克斯坦'], ['990198', '泰国'], ['990199', '多哥'], ['990200', '托克劳'], ['990201', '汤加'], ['990202', '特立尼达和多巴哥'], ['990203', '阿联酋'], ['990204', '突尼斯'], ['990205', '土尔其'], ['990206', '土库曼斯坦'], ['990207', '特克斯和凯科斯群岛'], ['990208', '图瓦卢'], ['990209', '乌干达'], ['990210', '乌克兰'], ['990211', '马其顿'], ['990212', '埃及'], ['990213', '英国'], ['990216', '坦桑尼亚'], ['990217', '美国'], ['990218', '美属维尔京群岛'], ['990219', '乌拉圭'], ['990220', '乌兹别克斯坦'], ['990221', '委内瑞拉'], ['990222', '瓦利斯和富图纳'], ['990223', '萨摩亚'], ['990224', '也门'], ['990225', '南斯拉夫'], ['990226', '赞比亚'], ]} };

CitySelect = function (input)
{
    this.input   = input;
    this.name    = input.name;

    this.selectP = null;
    this.selectC = null;
    

    var self = this;
    
    this.init = function ()
    {
        this.selectP = document.createElement('select');
        this.selectP.name = 'city_id';
        this.selectP.className = 'required';
        this.selectP.options[0] = new Option("请选择","");
        
        var i = 1;
        for (var pid in cities)
        {
            this.selectP.options[i] = new Option(cities[pid]['name'], pid);
            i ++;
        }        
        
        this.selectP.onchange = function () 
        {
            self.set(this.options[this.options.selectedIndex].value);
        }
               
        this.input.parentNode.insertBefore(this.selectP, this.input);

        this.selectC = document.createElement('select');
        this.selectC.name = this.name;

        this.input.parentNode.insertBefore(this.selectC, this.input);

        this.input.parentNode.removeChild(this.input);
        
        this.select(this.input.value);
    }

    this.set = function (pid)
    {
        // clear
        var num = this.selectC.length;
        for (var i = 0; i < num; i ++)
        {
            this.selectC.removeChild(this.selectC.options[0]);
        }
        
        if (pid == 0)
        {
            this.selectC.style.display = 'none';
            return;
        }

        this.selectC.style.display = 'inline';

        for (var i = 0; i < this.selectP.options.length; i ++)
        {
            if (this.selectP.options[i].value == pid)
            {
                this.selectP.options[i].selected = true;
            }
        }

        for (var i = 0; i < cities[pid]['cities'].length; i ++)
        {
            if (cities[pid]['cities'][i])
            {
                this.selectC.options[i] = new Option(cities[pid]['cities'][i][1], cities[pid]['cities'][i][0]);
            }
        }
    }

    this.select = function (cid)
    {
        if (!cid)
        {
            return;
        }

        var pid = cid.substr(0, 2) + "0000";

        this.set(pid);

        for (var i = 0; i < this.selectC.options.length; i ++)
        {
            if (this.selectC.options[i].value == cid)
            {
                this.selectC.options[i].selected = true;
            }
        }
    }
    
    this.init();
}

function makeCitySelect()
{
    var inputs = document.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i ++)
    {
        if (inputs[i].title == 'CitySelect')
        {
            new CitySelect(inputs[i]);
        }
    }
}

if (document.all)
{
    window.attachEvent('onload', makeCitySelect);
}
else
{
    window.addEventListener('load', makeCitySelect, false);
}