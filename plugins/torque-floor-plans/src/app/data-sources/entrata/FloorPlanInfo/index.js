import style from "./FloorPlanInfo.scss";
import React, { memo, useState, useMemo } from "react";
import classnames from "classnames";
import printer from "./icons/eleven33-printer.png";
import search from "./icons/eleven33-search.png";
import share from "./icons/eleven33-share.png";

const FloorPlanInfo = ({
  floorPlan: {
    post_title,
    rsf,
    thumbnail,
    key_plan_src: keyPlanSrc,
    units,
    min_price,
    max_price
  }
}) => {
  const [isModalOpen, setModalOpen] = useState(false);
  const toggleModalOpen = () => setModalOpen(!isModalOpen);

  const [isSocialOpen, setSocialOpen] = useState(false);
  const toggleSocialOpen = () => setSocialOpen(!isSocialOpen);

  const { href } = window.location;
  const socials = {
    facebook: encodeURI(`https://www.facebook.com/sharer/sharer.php?u=${href}`),
    twitter: encodeURI(`https://twitter.com/home?status=${href}`),
    pinterest: encodeURI(
      `https://pinterest.com/pin/create/button/?url=${href}&media=${thumbnail}`
    ),
    google: encodeURI(`https://plus.google.com/share?url=${href}`),
    "envelope-o": `mailto:?subject=${post_title}&body=${href}`
  };

  const hasAvailability = Boolean(units?.available?.length);

  const sortedAvailableUnits = useMemo(
    () =>
      units.available.sort((a, b) => {
        return (
          a?.Rent?.["@attributes"]?.MinRent - b?.Rent?.["@attributes"]?.MinRent
        );
      }),
    [units.available]
  );

  return (
    <div className={classnames("floor-plan-info", style.root)}>
      <div className="floor-plan-info-block floor-plan-name">
        <div className="title">{post_title}</div>
        <div className="rsf">{`${rsf} RSF`}</div>
        <div className="call">
          {hasAvailability
            ? min_price === max_price
              ? `$${min_price}`
              : `$${min_price} - $${max_price}`
            : "Call for availability"}
        </div>
      </div>

      <div className="floor-plan-info-block floor-plan-share">
        <div>Share</div>

        <div className="icons-wrapper">
          <a href={thumbnail} target="_blank" referrer="noreferrer noopener">
            <div className="share-icon print">
              <img src={printer} />
            </div>
          </a>

          <div className="share-icon enlarge" onClick={toggleModalOpen}>
            <img src={search} />
          </div>

          <div className={classnames(style.share, "share-icon", "share")}>
            {isSocialOpen && (
              <div
                className={classnames(style.social_wrapper, "social-wrapper")}
              >
                {Object.keys(socials).map(social => (
                  <a
                    href={socials[social]}
                    target="_blank"
                    className={`social-link ${social}`}
                  >
                    <i class={`fa fa-${social} fa-border`} />
                  </a>
                ))}
              </div>
            )}

            <img src={share} onClick={toggleSocialOpen} />
          </div>
        </div>
      </div>

      <div className="floor-plan-info-block floor-plan-key">
        <img src={keyPlanSrc} />
      </div>

      {hasAvailability && (
        <div className="floor-plan-info-block floor-plan-units">
          <div className="floor-plan-availability-title">Availability</div>
          {sortedAvailableUnits.map(unit => (
            <div
              key={unit["@attributes"].UnitNumber}
              className="floor-plan-unit"
            >
              <div className="foor-plan-unit-floor-plan-name">
                {unit?.["@attributes"]?.UnitNumber || "N/A"}
              </div>
              <div className="foor-plan-unit-floor-plan-price">
                {unit.pretty_price}
              </div>
              <div className="foor-plan-unit-apply-online">
                <a
                  href={`https://www.eleven33apartments.com/Apartments/module/application_authentication/http_referer/www.eleven33apartments.com/popup/false/kill_session/1/property[id]/${
                    unit["@attributes"].PropertyId
                  }/property_floorplan[id]/${
                    unit["@attributes"].FloorplanId
                  }/unit_space[id]/${
                    unit["@attributes"].PropertyUnitId
                  }/show_in_popup/false/from_check_availability/1/term_month/13/?lease_start_date=${
                    window.torqueStartDate
                  }`}
                  target="_blank"
                  referrer="noopener noreferrer"
                >
                  Apply Online
                </a>
              </div>
            </div>
          ))}
        </div>
      )}

      {isModalOpen && (
        <div className={style.modal_wrapper} onClick={toggleModalOpen}>
          <div className={style.modal}>
            <img src={thumbnail} />
          </div>
        </div>
      )}
    </div>
  );
};

export default memo(FloorPlanInfo);
