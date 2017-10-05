@extends('web.layouts.master')

@section('cssContent')
    <link rel="stylesheet" href="{{ asset('/css/culture.css') }}">
@endsection

@section('content')
    <div class="mainContainer">
        <div class="mainNav">
            <ul>
                <li class="title">关于我们</li>
                <li><a href="/about">企业简介</a></li>
                <li><a class="active" href="/culture">企业文化</a></li>
            </ul>
        </div>

        <div class="mainContent">
            <div class="cultureDiv">
                <!--企业哲学-->
                <p><i class="titleOne">企业哲学</i><i class="titleTwo">COMPANY&nbsp;&nbsp;INTRODUCTION</i></p>

                <div class="separateLine">
                    <div class="separateLineLeft"></div>
                </div>

                <div class="floor">
                    <div class="floorOneImage"></div>

                    <div class="floorOneContent">
                        <h3>大德帷幄&nbsp;上品智造</h3>
                        <p style="text-indent: 2em;">以“以德载道”的情怀。“企业之德”是企业文化建设的重要组成部分之意，是企业文化的高层次意识，可以营造良好的企业文化，促进企业发展。</p>
                        <p style="text-indent: 2em;">以“运筹帷幄”的魄力。市场的竞争永远没有宁静，企业面临的挑战从来就没有停止。公司要生产，产业要发展，必须“运筹帷幄，以动制动”。</p>
                        <p style="text-indent: 2em;">以“匠心上品”的决心。匠心是对工艺的不断升华，上品即质量好的或等级高的产品。</p>
                        <p style="text-indent: 2em;">以“行业创新”的引领。随着社会发展传统制造业对中国经济增长的贡献已经略显乏力，新形势下，冷柜行业必须通过创新驱动、品质革命，采用精品战略，挖掘新的发展机遇创造新的市场经济。</p>
                    </div>

                    <div class="mainClear"></div>
                </div>

                <!--企业定位-->
                <div class="floor">
                    <div class="floorTwoContent">
                        <p><i class="titleOne">企业定位</i><i class="titleTwo">COMPANY&nbsp;&nbsp;INTRODUCTION</i></p>

                        <div class="separateLine">
                            <div class="separateLineLeft"></div>
                        </div>

                        <h3>专业商冷&nbsp;制业智造</h3>
                        <p>我们不是单纯的设备制造商，</p>
                        <p>我们专注于制冷行业的全服务，</p>
                        <p>我们拥有自己的核心科技，</p>
                        <p>我们在市场上具备了自己的产品优势，</p>
                        <p>我们致力于专注、创新的功能性利益，</p>
                        <p>同样注重给与客户可信赖的情感性利益。</p>
                    </div>

                    <div class="floorTwoImage"></div>

                    <div class="mainClear"></div>
                </div>

                <!--企业核心价值观-->
                <p><i class="titleOne">企业核心价值观</i><i class="titleTwo">COMPANY&nbsp;&nbsp;INTRODUCTION</i></p>

                <div class="separateLine">
                    <div class="separateLineLeft"></div>
                </div>

                <div class="floor">
                    <div class="floorThreeImage"></div>

                    <div class="floorThreeContent">
                        <h3>诚信、品质、创新、服务</h3>
                        <p>诚信：诚实守信，永续经营。</p>
                        <p>品质：精益求精，追求卓越。</p>
                        <p>创新：积极进取，创造新意。</p>
                        <p>服务：服务至上，始终如一。</p>
                    </div>

                    <div class="mainClear"></div>
                </div>

                <!--企业愿景、企业使命-->
                <div class="floor">
                    <div class="floorFourContent">
                        <p><i class="titleOne">企业愿景</i><i class="titleTwo">COMPANY&nbsp;&nbsp;INTRODUCTION</i></p>

                        <div class="separateLine">
                            <div class="separateLineLeft"></div>
                        </div>

                        <h3>做百年大上，创世界品牌</h3>

                        <br>

                        <p><i class="titleOne">企业使命</i><i class="titleTwo">COMPANY&nbsp;&nbsp;INTRODUCTION</i></p>

                        <div class="separateLine">
                            <div class="separateLineLeft"></div>
                        </div>

                        <h3>致力于商业制冷全套解决方案提升中国商业制冷的全球综合竞争力</h3>
                    </div>

                    <div class="floorFourImage"></div>

                    <div class="mainClear"></div>
                </div>

                <!--END-->
                <div class="floor">
                    <div class="floorFiveImage"></div>

                    <div class="floorFiveContent">
                        <h3>大德帷幄&nbsp;上品智造</h3>
                        <p>大上电器</p>
                        <p>先有德，后立业；</p>
                        <p>以德铸魂，立业塑形；</p>
                        <p>大德方能帷幄，上品彰显智造；</p>
                        <p>对内以人，达人成己；对外以心，真诚经营；</p>
                        <p>统一目标，贯穿始终；创新驱动，创造价值；</p>
                        <p>行动现场化，管理标准化，运作人本化；</p>
                        <p>节俭为本，提高核算意识；</p>
                        <p>重视合作关系，实现互信共赢，贯彻客户至上原则；</p>
                        <p>至真至诚，保持明朗之心；唯才是举，以德为先；</p>
                        <p>源于学习，成于进取；团结合作，共建可信赖团队；</p>
                        <p>精益求精，完美制造。</p>
                    </div>

                    <div class="mainClear"></div>
                </div>
            </div>
        </div>

        <div class="mainClear"></div>
    </div>
@endsection
