{{--<div wire:loading>--}}
{{--  <div class="spinner-border spinner-border-sm" role="status"></div>--}}
{{--</div>--}}

@push('styles')
  <style>
      /*1*/
      #overlay {
          background: #ffffff;
          color: #666666;
          position: fixed;
          height: 100%;
          width: 100%;
          z-index: 5000;
          top: 0;
          left: 0;
          float: left;
          text-align: center;
          padding-top: 25%;
          opacity: .80;
      }

      .spinner {
          margin: 0 auto;
          height: 64px;
          width: 64px;
          animation: rotate 0.8s infinite linear;
          /*border: 5px solid firebrick;*/
          border-left: 6px solid rgba(0, 174, 239, .15);
          border-right: 6px solid rgba(0, 174, 239, .15);
          border-bottom: 6px solid rgba(0, 174, 239, .15);
          border-top: 6px solid rgba(0, 174, 239, .8);
          /*border-right-color: transparent;*/
          border-radius: 50%;
      }

      @keyframes rotate {
          0% {
              transform: rotate(0deg);
          }
          100% {
              transform: rotate(360deg);
          }
      }


      /*2*/
      /*.spinner {*/
      /*    height: 60px;*/
      /*    width: 60px;*/
      /*    margin: auto;*/
      /*    display: flex;*/
      /*    position: absolute;*/
      /*    -webkit-animation: rotation .6s infinite linear;*/
      /*    -moz-animation: rotation .6s infinite linear;*/
      /*    -o-animation: rotation .6s infinite linear;*/
      /*    animation: rotation .6s infinite linear;*/
      /*    border-left: 6px solid rgba(0, 174, 239, .15);*/
      /*    border-right: 6px solid rgba(0, 174, 239, .15);*/
      /*    border-bottom: 6px solid rgba(0, 174, 239, .15);*/
      /*    border-top: 6px solid rgba(0, 174, 239, .8);*/
      /*    border-radius: 100%;*/
      /*}*/

      /*@-webkit-keyframes rotation {*/
      /*    from {*/
      /*        -webkit-transform: rotate(0deg);*/
      /*    }*/
      /*    to {*/
      /*        -webkit-transform: rotate(359deg);*/
      /*    }*/
      /*}*/

      /*@-moz-keyframes rotation {*/
      /*    from {*/
      /*        -moz-transform: rotate(0deg);*/
      /*    }*/
      /*    to {*/
      /*        -moz-transform: rotate(359deg);*/
      /*    }*/
      /*}*/

      /*@-o-keyframes rotation {*/
      /*    from {*/
      /*        -o-transform: rotate(0deg);*/
      /*    }*/
      /*    to {*/
      /*        -o-transform: rotate(359deg);*/
      /*    }*/
      /*}*/

      /*@keyframes rotation {*/
      /*    from {*/
      /*        transform: rotate(0deg);*/
      /*    }*/
      /*    to {*/
      /*        transform: rotate(359deg);*/
      /*    }*/
      /*}*/

      /*#overlay {*/
      /*    position: absolute;*/
      /*    display: none;*/
      /*    top: 0;*/
      /*    left: 0;*/
      /*    right: 0;*/
      /*    bottom: 0;*/
      /*    background-color: rgba(0, 0, 0, 0.5);*/
      /*    z-index: 2;*/
      /*    cursor: pointer;*/
      /*}*/
  </style>
@endpush

<div wire:loading.delay>
  {{--  1--}}
  <div id="overlay">
    <div class="spinner"></div>
  </div>

  {{--  2--}}
  {{--  <div id="overlay d-flex">--}}
  {{--    <div class="spinner"></div>--}}
  {{--  </div>--}}
</div>

@push('scripts')
  {{--  1--}}
  <script>
      $(document).ready(function () {
          $('#overlay').fadeIn().fadeOut();
      });
  </script>
@endpush
